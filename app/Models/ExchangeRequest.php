<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExchangeRequest
 * Модель заявки , так же используется
 * и в качестве ответа на заявку
 * @package App\Models
 */
class ExchangeRequest extends Model
{
    protected $fillable = [
        'currency_from',
        'currency_to',
        'payment_system_from',
        'payment_system_to',
        'sys_wallet',
        'amount_from',
        'amount_to',
        'rate',
        'wallet_from',
        'wallet_to',
        'transaction_type',
        'payment_type',
        'request_id',
        'amount_get',
        'commission',
        'exchange_number'
    ];

    /**
     * Возвращает валюту которую хочет получить пользователь
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currencyTo()
    {
        return $this->belongsTo(Currency::class, 'currency_to');
    }

    /**
     * Возвращает валюту которую отдает пользователь
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currencyFrom()
    {
        return $this->belongsTo(Currency::class, 'currency_from');
    }

    /**
     * Возвращает платежную систему на которую пользователь
     * хочет получить средства
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentSystemTo()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_to');
    }

    /**
     * Возвращает платежную систему на которую пользователь
     * перевел средства
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentSystemFrom()
    {
        return $this->belongsTo(PaymentSystem::class, 'payment_system_from');
    }

    /**
     * Возвращает тип транзакции
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type');
    }

    /**
     * Возвращает тип платежа
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type');
    }

    /**
     * Возвращает статус заявки
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * Возвращает статус платежа на кошелек сервиса
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payToServiceStatus()
    {
        return $this->belongsTo(Status::class, 'pay_to_service_status');
    }

    /**
     * Возвращает пользователя заявки
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Возвращает тип заявки
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function requestType()
    {
        return $this->belongsTo(RequestType::class, 'request_type');
    }

    /**
     * Возвращает ответ на заявку если данная заявка
     * является запросом на обмен
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reply()
    {
        return $this->hasMany(ExchangeRequest::class, 'request_id', 'id');
    }

    /**
     * Возвращает запрос на обмен если данная заявка
     * является ответом на запрос
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function request()
    {
        return $this->hasOne(ExchangeRequest::class, 'id', 'request_id');
    }

    /**
     * Возвращает кошелек пользователя откуда был произведен
     * платеж
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function walletFrom()
    {
        return $this->belongsTo(Wallet::class, 'wallet_from');
    }

    /**
     * Возвращает кошелек на который пользователь хочет получить средства
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function walletTo()
    {
        return $this->belongsTo(Wallet::class, 'wallet_to');
    }

    /**
     * Возвращает системный кошелек
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sysWallet()
    {
        return $this->belongsTo(Wallet::class, 'sys_wallet');
    }
}
