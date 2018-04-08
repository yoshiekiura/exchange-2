<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ExchangeRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExchangeRequestCollection;

/**
 * Class FilterController
 * @package App\Http\Controllers\API
 */
class FilterController extends Controller
{
    /**
     * Применяем параметры фильтра к запросу
     * @param Request $request
     *
     * @return ExchangeRequestCollection
     */
    public function userRequestFilter(Request $request)
    {
        $data = $request->all();

        $user = auth()->user();

        // Создаем обьект QueryBuilder для модели заявки
        $query = $user->requests()->with([
            'requestType',
            'currencyTo',
            'currencyFrom',
            'paymentSystemFrom',
            'paymentSystemTo',
            'status',
        ]);

        // Модифицируем запрос добавляя в него нужные условия
        if (! empty($data['request_type'])) {
            $query->where('request_type', $data['request_type']);
        }

        if (! empty($data['request_status'])) {
            $query->where('status_id', $data['request_status']);
        }

        // Применяем фильтр и возвращаем результат
        $requests = $query
            ->orderBy('rate', 'DESC')
            ->paginate(10);

        return (new ExchangeRequestCollection($requests));
    }

    /**
     * Применяем параметры фильтра к запросу
     * @param Request $request
     *
     * @return ExchangeRequestCollection
     */
    public function requestFilter(Request $request)
    {
        $data = $request->all();

        // Создаем обьект QueryBuilder для модели заявки
        $query = ExchangeRequest::query()->with([
            'currencyTo',
            'currencyFrom',
            'paymentSystemFrom',
            'paymentSystemTo',
        ]);

        // Модифицируем запрос добавляя в него нужные условия
        if (! empty($data['filter_from'])) {
            $filter = $data['filter_from'];

            if (! empty($filter['currency'])) {
                $query->whereHas('currencyFrom', function ($query) use ($filter) {
                    $query->where('equivalent_id', $filter['currency']);
                });
            }

            if (! empty($filter['payment_system'])) {
                $query->where('payment_system_from', $filter['payment_system']);
            }
        }

        if (! empty($data['filter_to'])) {
            $filter = $data['filter_to'];

            if (! empty($filter['currency'])) {
                $query->whereHas('currencyTo', function ($query) use ($filter) {
                    $query->where('equivalent_id', $filter['currency']);
                });
            }

            if (! empty($filter['payment_system'])) {
                $query->where('payment_system_to', $filter['payment_system']);
            }
        }

        if (! empty($data['amount'])) {
            $amount = $data['amount'];

            if (! empty($amount['from'])) {
                $query->where('amount_from', '>', $amount['from']);
            }

            if (! empty($amount['to'])) {
                $query->where('amount_from', '<', $amount['to']);
            }
        }

        // Применяем фильтр и возвращаем результат
        $requests = $query->where('request_type', 1)
          ->where('status_id', 2)
          ->orderBy('rate', 'DESC')
          ->paginate(10);

        return (new ExchangeRequestCollection($requests));
    }
}
