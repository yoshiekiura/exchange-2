<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rate
 * Модель курса пары валют.
 * Используется для кеширования
 * курса тем самым уменьшая кол-во
 * запросов на сторонний API
 * @package App\Models
 */
class Rate extends Model
{
    protected $fillable = ['pair', 'rate'];
}
