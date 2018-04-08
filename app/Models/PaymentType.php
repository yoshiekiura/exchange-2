<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentType
 * Модель способа оплаты заявки
 * @package App\Models
 */
class PaymentType extends Model
{
    /**
     * Возвращает все заявки с данным типом оплаты
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(ExchangeRequest::class);
    }
}
