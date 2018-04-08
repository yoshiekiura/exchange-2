<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * Модель валюты
 * @package App\Models
 */
class Currency extends Model
{
    /**
     * Возвращает платежные системы доступные данной валюте
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function paymentSystems()
    {
        return $this->belongsToMany(PaymentSystem::class);
    }

    /**
     * Возвращает эквивалент данной валюты
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equivalent()
    {
        return $this->belongsTo(Equivalent::class);
    }

    /**
     * Возвращает все заявки использующие данную валюту
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchangeRequests()
    {
        return $this->hasMany(ExchangeRequest::class);
    }
}
