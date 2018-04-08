<?php

namespace App\Http\Controllers\API;

use App\Models\RequestType;
use App\Http\Controllers\Controller;

/**
 * Class RequestTypeController
 * @package App\Http\Controllers\API
 */
class RequestTypeController extends Controller
{
    /**
     * Возвращаем все типы запросов
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRequestTypes()
    {
        $types = RequestType::all();
        return response()->json($types, 200);
    }
}
