<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 * Модель контакта для связи
 * пользователя с администрацией
 * @package App\Models
 */
class Contact extends Model
{
    protected $fillable = ['name', 'email', 'text'];
}
