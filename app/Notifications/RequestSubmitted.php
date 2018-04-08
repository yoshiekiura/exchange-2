<?php

namespace App\Notifications;

use App\Models\Currency;
use App\Models\ExchangeRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class RequestSubmitted extends Notification
{
    use Queueable;

    private $request = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ExchangeRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toTelegram($notifiable)
    {
        $data = $this->getRequestData();

        $msg = "У вас новая заявка!
                \nНомер заявки : {$data['number']}
                \nВнесенная сумма : {$data['from']} 
                \nСумма для выплаты : {$data['to']}";

        return TelegramMessage::create($msg)
            ->to('336000199')
            ->button('К заявке', $data['url']);
    }

    public function toMail($notifiable)
    {
        $data = $this->getRequestData();

        return (new MailMessage)
            ->subject('Новая заявка')
            ->from(config('mail.username'), 'Mirobmena')
            ->greeting('У вас новая заявка!')
            ->line('Номер заявки : ' . $data['number'])
            ->line('Внесенная сумма : ' . $data['from'])
            ->line('Сумма для выплаты : ' . $data['to'])
            ->action('К заявке', $data['url']);
    }

    protected function getRequestData()
    {
        $data['number'] = $this->request->exchange_number;
        $data['from'] = (float)$this->request->amount_from . Currency::find($this->request->currency_from)->sign;
        $data['to'] = (float)$this->request->amount_get . Currency::find($this->request->currency_to)->sign;
        $data['url'] = url("/admin/exchange_requests/{$this->request->id}/edit");
        return $data;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
