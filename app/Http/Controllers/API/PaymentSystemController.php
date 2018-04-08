<?php

namespace App\Http\Controllers\API;

use App\Models\Equivalent;
use App\Models\PaymentSystem;
use App\Http\Controllers\Controller;

/**
 * Class PaymentSystemController
 * @package App\Http\Controllers\API
 */
class PaymentSystemController extends Controller
{
    /**
     * Возвращаем все платежные системы , доступные
     * для валюты по её эквиваленту
     * @param Equivalent $equivalent
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSupportedPaymentSystems(Equivalent $equivalent)
    {
        $payment_systems = Collect();

        $equivalent->load(['currencies.paymentSystems' => function ($query) {
            $query->where('active', true);
        }]);

        foreach ($equivalent->currencies as $item) {
            $payment_systems = $payment_systems->merge($item->paymentSystems);
        }

        $payment_systems = $payment_systems->unique('id');

        return response()->json($payment_systems, 200);
    }

    /**
     * Возвращаем название платежной системы
     * @param $payment_system
     * @param $currency
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentSystemName($payment_system, $currency)
    {
        $ps = PaymentSystem::find($payment_system)->name;
        $currency = Equivalent::find($currency)->code;
        return response()->json("$ps($currency)", 200);
    }

    /**
     * Возвращаем все активные платежные системы
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentSystems()
    {
        $ps = PaymentSystem::whereActive(true)->get();
        return response()->json($ps, 200);
    }
}
