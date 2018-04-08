<?php

namespace App\Notifications;

use App\Models\Currency;
use Illuminate\Bus\Queueable;
use App\Models\ExchangeRequest;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class ReplySubmitted extends Notification
{
    use Queueable;

    private $request = null;

    /**
     * ReplySubmitted constructor.
     *
     * @param ExchangeRequest $request
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
        return [TelegramChannel::class, 'mail'];
    }

    public function toTelegram($notifiable)
    {
        $data = $this->getRequestData();

        $msg = "У вас новый ответ на заявку!
                \nНомер заявки : {$data['number']}
                \nВнесенная сумма : {$data['from']} 
                \nСумма для выплаты : {$data['to']}";

        return TelegramMessage::create($msg)
            ->to('336000199')
            ->button('К заявке', $data['url']);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = $this->getRequestData();

        return (new MailMessage)
            ->subject('Ответ на заявку')
            ->from(config('mail.username'), 'Mirobmena')
            ->greeting('У вас новый ответ на заявку!')
            ->line('Номер заявки : ' . $data['number'])
            ->line('Внесенная сумма : ' . $data['from'])
            ->line('Сумма для выплаты : ' . $data['to'])
            ->action('К заявке', $data['url']);
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

    protected function getRequestData()
    {
        $data['number'] = $this->request->exchange_number;
        $data['from'] = (float)$this->request->amount_from . Currency::find($this->request->currency_from)->sign;
        $data['to'] = (float)$this->request->amount_get . Currency::find($this->request->currency_to)->sign;
        $data['url'] = url("/admin/exchange_requests/{$this->request->id}/edit");
        $data['url'] = url('/');
        return $data;
    }
}
