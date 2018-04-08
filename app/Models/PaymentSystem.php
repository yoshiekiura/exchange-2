<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentSystem
 * Модель платежной системы
 * @package App\Models
 */
class PaymentSystem extends Model
{
    /**
     * Возвращает все валюты доступные данной платежной системе
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function currencies()
    {
        return $this->belongsToMany(Currency::class);
    }

    /**
     * Возвращает все кошельки доступные данной платежной системе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    /**
     * Возвращает все заявки доступные данной платежной системе
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchangeRequests()
    {
        return $this->hasMany(ExchangeRequest::class);
    }

    /**
     * Возвращает системный кошелек для данной платежной системы
     * @return $this
     */
    public function systemWallet()
    {
        return $this->hasMany(Wallet::class)->where('wallet_type', 'system');
    }
}
