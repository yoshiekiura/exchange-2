<?php

namespace App\Http\Controllers\API;

use App\Models\Wallet;
use App\Models\Equivalent;
use Illuminate\Http\Request;
use App\Models\PaymentSystem;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletCollection;

/**
 * Class WalletController
 * @package App\Http\Controllers\API
 */
class WalletController extends Controller
{
    /**
     * Получаем кошельки аутентифицированного пользователя
     * @return WalletCollection
     */
    public function getUserWallets()
    {
        $user = auth()->user();
        $wallets = $user->wallets()->with([
            'currency',
            'payment_system'
        ])->paginate(10);

        return (new WalletCollection($wallets));
    }

    /**
     * Получаем системный кошелек по эквиваленту
     * и платежной системе
     * @param $equiv
     * @param $ps
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSystemWallet($equiv, $ps)
    {
        $currencies = Equivalent::find($equiv)->currencies->pluck('id');

        $wallet = PaymentSystem::find($ps)
            ->wallets()
            ->whereIn('currency_id', $currencies)
            ->first();

        return response()->json($wallet, 200);
    }

    /**
     * Получаем кошелек по id
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWallet($id)
    {
        $wallet = Wallet::with([
            'currency'
        ])->find($id);

        return response()->json($wallet, 200);
    }

    /**
     * Редактируем данные кошелька
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editWallet($id, Request $request)
    {
        $data = $request->all();

        $data['currency_id'] = PaymentSystem::find($data['payment_system_id'])
            ->currencies()
            ->where('equivalent_id', $data['currency_id'])
            ->first()->id;

        Wallet::find($id)->update($data);

        return response()->json(true, 200);
    }

    /**
     * Удаляем кошелек по id
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteWallet($id)
    {
        Wallet::destroy($id);

        return response()->json(true, 200);
    }

    /**
     * Создаем кошелек
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createWallet(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $data['currency_id'] = PaymentSystem::find($data['payment_system_id'])
            ->currencies()
            ->where('equivalent_id', $data['currency_id'])
            ->first()->id;

        $data['user_id'] = $user->id;
        $data['wallet_type'] = 'user';

        $wallet = new Wallet($data);

        if ($wallet->save()) {
            return response()->json(true, 200);
        }

        return response()->json([], 500);
    }

    /**
     * Возвращаем все кошельки пользователя по эквиваленту
     * и платежной системе
     * @param $equivalent
     * @param $payment_system
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function selectWallets($equivalent, $payment_system)
    {
        $ps = PaymentSystem::find($payment_system);

        $wallets = $ps
            ->wallets()
            ->where('user_id', auth()->id())
            ->whereHas('currency', function ($query) use ($equivalent) {
                $query->where('equivalent_id', $equivalent);
                $query->where('wallet_type', 'user');
            })->get();

        return response()->json($wallets, 200);
    }
}
