<?php

namespace App\Http\Controllers\API;

use App\User;
use Carbon\Carbon;
use App\Models\Wallet;
use Mockery\Exception;
use Illuminate\Http\Request;
use App\Models\PaymentSystem;
use App\Models\ExchangeRequest;
use App\Http\Controllers\Controller;
use App\Notifications\ReplySubmitted;
use App\Notifications\RequestSubmitted;
use App\Http\Resources\ExchangeRequestCollection;

/**
 * Class ExchangeRequestController
 * @package App\Http\Controllers\API
 */
class ExchangeRequestController extends Controller
{
    /**
     * Создаем запрос на обмен
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeExchangeRequest(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        // Начало оформления заявки
        $exchangeRequest = new ExchangeRequest($data);
        $exchangeRequest->status_id = 2;
        $exchangeRequest->request_type = 1;
        $exchangeRequest->user_id = $user->id;
        $exchangeRequest->pay_to_service_status = 2;
        $exchangeRequest->exchange_number = $this->setExchangeNumber();

        $exchangeRequest->currency_from = $this->setCurrency(
            $exchangeRequest->currency_from,
            $exchangeRequest->payment_system_from
        );

        $exchangeRequest->currency_to = $this->setCurrency(
            $exchangeRequest->currency_to,
            $exchangeRequest->payment_system_to
        );

        // Парсим данные из запроса и достаем id системного кошелька
        if (is_array($exchangeRequest->sys_wallet)) {
            $exchangeRequest->sys_wallet = $exchangeRequest->sys_wallet['id'];
        }

        // Если есть id кошелька устанавливаем его ,
        // в противном случае создаем новый
        if ($data['wallet_id_from']) {
            $exchangeRequest->wallet_from = $data['wallet_id_from'];
        } else {
            $exchangeRequest->wallet_from = $this->createWallet(
                $exchangeRequest->currency_from,
                $exchangeRequest->payment_system_from,
                $data['wallet_number_from']
            )->id;
        }

        if ($data['wallet_id_to']) {
            $exchangeRequest->wallet_to = $data['wallet_id_to'];
        } else {
            $exchangeRequest->wallet_to = $this->createWallet(
                $exchangeRequest->currency_to,
                $exchangeRequest->payment_system_to,
                $data['wallet_number_to']
            )->id;
        }

        // Если запрос прошел валидацию и удачно сохранен в БД,
        // то отправляем уведомления , в противном случае возвращаем
        // ответ с неудачей
        if ($this->validateRequest($exchangeRequest)) {
            if ($exchangeRequest->save()) {
                $admin = User::where('role', 'admin')->first();

                try {
                    $admin->notify(new RequestSubmitted($exchangeRequest));
                } catch (Exception $exception) {
                    return response()->json(['success' => true], 200);
                }

                return response()->json(['success' => true], 200);
            }
        }

        return response()->json(['success' => false], 200);
    }

    /**
     * Создаем ответ на запрос
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function replyExchangeRequest(Request $request)
    {
        $data = $request->all();
        $user = auth()->user();

        // Находим запрос , на который мы будем делать ответ
        // и блокируем его на время обновления
        $exchangeRequest = ExchangeRequest::lockForUpdate()
            ->find($data['request_id']);

        // Если заявитель является ответчиком прекращаем оформление заявки
        if ($user->id === $exchangeRequest->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Вы не можете выкупить свою же заявку.'
            ], 200);
        }

        // Если выкупаем всю заявку , то в качестве суммы обмена
        // устанавливаем запрашиваемую сумму заявителем
        // в противном случае устанавливаем сколько было выкуплено
        // из заявки и делаем проверки
        if ($exchangeRequest->transaction_type === 1) {
            $data['amount_from'] = $exchangeRequest->amount_to;
            $data['amount_to'] = $exchangeRequest->amount_from;
            $exchangeRequest->status_id = 4;
        } else {
            $exchangeRequest->redeemed += $data['amount_from'];

            if (bccomp($exchangeRequest->redeemed, $exchangeRequest->amount_to) === 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Введенная вами сумма больше доступной суммы выкупа.'
                ], 200);
            }
        }

        // Если из заявки выкуплена вся сумма устанавливаем статус
        // обработки для её дальнейшей обработки администратором
        if (bccomp($exchangeRequest->redeemed, $exchangeRequest->amount_to) === 0) {
            $exchangeRequest->status_id = 4;
        }

        // Заполняем ещё необходимые данные для создания заявки
        $data['payment_system_to'] = $exchangeRequest->payment_system_from;
        $data['payment_system_from'] = $exchangeRequest->payment_system_to;
        $data['currency_to'] = $exchangeRequest->currency_from;
        $data['currency_from'] = $exchangeRequest->currency_to;
        $data['exchange_number'] = $this->setExchangeNumber();

        // Создаем ответ на заявку
        $replyRequest = new ExchangeRequest($data);
        $replyRequest->status_id = 4;
        $replyRequest->payment_type = 1;
        $replyRequest->request_type = 2;
        $replyRequest->user_id = $user->id;
        $replyRequest->transaction_type = 1;
        $replyRequest->pay_to_service_status = 2;

        // Парсим данные из запроса и достаем id системного кошелька
        if (is_array($replyRequest->sys_wallet)) {
            $replyRequest->sys_wallet = $replyRequest->sys_wallet['id'];
        }

        // Если есть id кошелька устанавливаем его ,
        // в противном случае создаем новый
        if ($data['wallet_from']['id']) {
            $replyRequest->wallet_from = $data['wallet_from']['id'];
        } else {
            $replyRequest->wallet_from = $this->createWallet(
                $replyRequest->currency_from,
                $replyRequest->payment_system_from,
                $data['wallet_from']['number']
            )->id;
        }

        if ($data['wallet_to']['id']) {
            $replyRequest->wallet_to = $data['wallet_to']['id'];
        } else {
            $replyRequest->wallet_to = $this->createWallet(
                $replyRequest->currency_to,
                $replyRequest->payment_system_to,
                $data['wallet_to']['number']
            )->id;
        }

        // Сохраняем данные и при успешном исходе уведомляем пользователей
        if ($this->validateRequest($replyRequest, $exchangeRequest->rate)) {
            if ($replyRequest->save()) {
                $exchangeRequest->save();
                try {
                    $exchangeRequest->user->notify(new ReplySubmitted($replyRequest));
                    User::where('role', 'admin')
                        ->first()
                        ->notify(new RequestSubmitted($replyRequest));
                } catch (\Exception $exception) {
                    return response()->json(['success' => true], 200);
                }
                return response()->json(['success' => true], 200);
            }
        }
        return response()->json(['success' => false], 200);
    }

    /**
     * Получаем все доступные запросы на обмен
     * @return ExchangeRequestCollection
     */
    public function getRequests()
    {
        $requests = ExchangeRequest::with([
            'currencyTo',
            'currencyFrom',
            'paymentSystemFrom',
            'paymentSystemTo',
        ])->where('request_type', 1)
          ->where('status_id', 2)
          ->orderBy('rate', 'DESC')
          ->paginate(10);

        return (new ExchangeRequestCollection($requests));
    }

    /**
     * Получаем запрос по его id
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRequest($id)
    {
        $request = ExchangeRequest::with([
            'payment',
            'transaction',
            'currencyTo',
            'currencyFrom',
            'paymentSystemFrom',
            'paymentSystemTo',
            'reply.walletFrom',
            'reply.currencyFrom',
            'reply.currencyFrom.equivalent',
            'reply.paymentSystemFrom',
            'request.currencyTo',
            'request.currencyFrom',
            'request.paymentSystemFrom',
            'request.paymentSystemTo',
            'walletFrom',
        ])->find($id);

        return response()->json($request, 200);
    }

    /**
     * Получаем все запросы аутентифицированного пользователя
     * @return ExchangeRequestCollection
     */
    public function getUserRequests()
    {
        $user = auth()->user();
        $requests = $user->requests()->with([
            'requestType',
            'currencyTo',
            'currencyFrom',
            'paymentSystemFrom',
            'paymentSystemTo',
            'status',
        ])->paginate(10);

        return (new ExchangeRequestCollection($requests));
    }

    /**
     * Находит кошелек аутентифицированного пользователя по
     * валюте , платежной системе и номеру кошелька
     * или создает новый
     * @param $currency
     * @param $payment_system
     * @param $wallet_number
     *
     * @return $this|\Illuminate\Database\Eloquent\Model|null|static
     */
    protected function createWallet($currency, $payment_system, $wallet_number)
    {
        $user = auth()->user();

        $wallet = Wallet::where('currency_id', $currency)
            ->where('payment_system_id', $payment_system)
            ->where('user_id', $user->id)
            ->where('wallet_number', $wallet_number)
            ->where('wallet_type', 'user')
            ->first();

        if ($wallet) {
            return $wallet;
        }

        return Wallet::create([
            'currency_id' => $currency,
            'payment_system_id' => $payment_system,
            'user_id' => $user->id,
            'wallet_number' => $wallet_number,
            'wallet_type' => 'user'
        ]);
    }

    /**
     * Находим id валюты по её эквиваленту и платежной системе
     * @param $equivalent
     * @param $payment_system
     *
     * @return mixed
     */
    protected function setCurrency($equivalent, $payment_system)
    {
        return PaymentSystem::find($payment_system)
            ->currencies()
            ->where('equivalent_id', $equivalent)
            ->first()->id;
    }

    /**
     * Устанавливаем уникальный номер для заявки
     * @return string
     */
    protected function setExchangeNumber()
    {
        return 'EX' . Carbon::now()->format('dmyhms');
    }

    /**
     * Перерасчитывет данные заявки для удостоверения
     * в её корректности
     *
     * @param ExchangeRequest $request
     *
     * @param null $rate
     *
     * @return bool
     */
    protected function validateRequest(ExchangeRequest $request, $rate = null)
    {
        $precision_to = $request->currencyTo->equivalent_id === 4 ? 6 : 2;

        if ($rate) {
            $rate = round(1 / $rate, 6);
        } else {
            $rate = $request->rate;
        }

        $amount_to = round($request->amount_from * $rate, $precision_to);

        if ($request->request) {
            if ($request->request->transaction_type === 1) {
                $amount_to = $request->request->amount_from;
            }
        }

        $amount_get = round($amount_to - ($amount_to * 0.01), $precision_to);
        $commission = round($amount_to - $amount_get, $precision_to);

        $to = bccomp($amount_to, $request->amount_to);
        $get = bccomp($amount_get, $request->amount_get);
        $comm = bccomp($commission, $request->commission);

        if (!$to && !$get && !$comm) {
            return true;
        }

        return  false;
    }
}
