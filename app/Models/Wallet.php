<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * Модель кошелька
 * @package App\Models
 */
class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'payment_system_id',
        'currency_id',
        'wallet_number',
        'wallet_type',
    ];

    /**
     * Возвращает пользователя которому принадлежит кошелек
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Возвращает валюты данного кошелька
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Возвращает платежную систему данного кошелька
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment_system()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_id');
    }
}
