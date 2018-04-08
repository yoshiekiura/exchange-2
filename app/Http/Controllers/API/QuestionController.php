<?php

namespace App\Http\Controllers\API;

use App\Models\Question;
use App\Http\Controllers\Controller;

/**
 * Class QuestionController
 * @package App\Http\Controllers\API
 */
class QuestionController extends Controller
{
    /**
     * Возвращаем все активные вопросы
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions()
    {
        $questions = Question::where('active', true)
            ->orderBy('order', 'DESC')
            ->get();

        return response()->json($questions, 200);
    }
}
