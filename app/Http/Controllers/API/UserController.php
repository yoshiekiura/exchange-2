<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Проверяем аутентифицирован пользователь или нет
     * и возвращаем ответ
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth()
    {
        if (auth()->check()) {
            return response()->json(['success' => true, 'user_id' => auth()->user()->id], 200);
        }
        return response()->json(['success' => false], 200);
    }

    /**
     * Получаем пользователя по его id
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser($id)
    {
        if (auth()->check()) {
            $user = User::find($id);
            return response()->json($user, 200);
        }
        return response()->json(['success' => false], 404);
    }

    /**
     * Редактируем данные пользователя
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function editUser(LoginRequest $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        $user->update($data);

        return response()->json($user, 200);
    }

    /**
     * Получаем почту админа
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdminEmail()
    {
        $user = User::where('role', 'admin')->first();

        if ($user) {
            return response()->json($user->email, 200);
        }

        return response()->json(['success' => false], 404);
    }
}
