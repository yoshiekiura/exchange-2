<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionType
 * Модель типа транзакции
 * @package App\Models
 */
class TransactionType extends Model
{
    /**
     * Возвращает все заявки с данным типом
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(ExchangeRequest::class);
    }
}
