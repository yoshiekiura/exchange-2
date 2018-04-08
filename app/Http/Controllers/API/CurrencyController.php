<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Rate;
use App\Models\Equivalent;
use App\Models\RequestType;
use App\Models\PaymentSystem;
use Swap\Laravel\Facades\Swap;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * Возвращаем активные эквиваленты валют
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSupportedCurrencies()
    {
        $equivalents = Equivalent::whereActive(true)
            ->get(['id', 'name', 'code', 'sign', 'active']);

        return response()->json($equivalents, 200);
    }

    /**
     * Возвращает курс пары валют по эквиваленту валюты
     * и платежной системе
     * @param $from
     * @param $to
     * @param $ps_from
     * @param $ps_to
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrenciesRate($from, $to, $ps_from, $ps_to)
    {
        if ($from == 4) {
            $from = PaymentSystem::find($ps_from)
                ->currencies()
                ->where('equivalent_id', $from)
                ->first();

            $from ? $from = $from->code : abort(404);
        } else {
            $from = Equivalent::find($from)->code;
        }

        if ($to == 4) {
            $to = PaymentSystem::find($ps_to)
                ->currencies()
                ->where('equivalent_id', $to)
                ->first();

            $to ? $to = $to->code : abort(404);
        } else {
            $to = Equivalent::find($to)->code;
        }

        $rate = $this->checkRate(
            $from,
            $to
        );

        return response()->json($rate->rate, 200);
    }

    /**
     * Возвращает id валюты по эквиваленту и платежной системе
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
     * Производит перерасчёт заявок без ответов
     * используя свежие курсы валют
     */
    public function update()
    {
        // Удаляем кэшированные данные курсов
        DB::table('rates')->truncate();

        // Находим все заявки на обмен у которых ещё нет ответа
        $requests = RequestType::find(1)
            ->requests()
            ->where('status_id', 2)
            ->get();

        // Проганяем в цикле наши заявки и производим перерасчёт,
        // предварительно заблокировав его для обновления
        // используя новый курс, так-же сразу кэшируем его
        foreach ($requests as $request) {
            try {
                $rate = $this->checkRate(
                    $request->currencyFrom->code,
                    $request->currencyTo->code
                );

                $request->lockForUpdate();

                $request->rate = $rate->rate;
                $request->amount_to = $request->amount_from * $request->rate;
                $request->amount_get = $request->amount_to - ($request->amount_to * 0.01);
                $request->commission = $request->amount_to - $request->amount_get;

                $request->save();
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    /**
     * Возвращаем закешированный курс запрашиваемой пары валют
     * либо делаем запрос на API для получения курса и кэшируем его
     *
     * @param $from
     * @param $to
     *
     * @return $this|\Illuminate\Database\Eloquent\Model|null|static
     * @internal param string $pair
     *
     */
    private function checkRate($from, $to)
    {
        $pair = $from . '/' . $to;

        $rate = Rate::where('pair', $pair)->first();

        return $rate ? $rate : Rate::create([
            'pair' => $pair,
            'rate' => Swap::latest($pair)->getValue()
        ]);
    }
}
