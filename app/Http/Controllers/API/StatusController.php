<?php

namespace App\Http\Controllers\API;

use App\Models\Status;
use App\Http\Controllers\Controller;

/**
 * Class StatusController
 * @package App\Http\Controllers\API
 */
class StatusController extends Controller
{
    /**
     * Возвращаем все статусы заявок
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatuses()
    {
        $statuses = Status::all();
        return response()->json($statuses, 200);
    }
}
