<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Equivalent
 * Модель эквивалента валюты
 * @package App\Models
 */
class Equivalent extends Model
{
    /**
     * Возвращает все валюты доступные данному эквиваленту
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }
}
