<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestType
 * Модель типа запроса.
 * @package App\Models
 */
class RequestType extends Model
{
    /**
     * Возвращает все запросы данного типа
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(ExchangeRequest::class, 'request_type');
    }
}
