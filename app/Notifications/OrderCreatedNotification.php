<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Broadcast;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $order;
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
        $channels = ['database'];
        if ($notifiable->notification_preferences['order_create']['sms']) {
            $channels = ['vonage'];
        }
        if ($notifiable->notification_preferences['order_create']['mail']) {
            $channels = ['mail'];
        }
        if ($notifiable->notification_preferences['order_create']['broadcast']) {
            $channels = ['broadcast'];
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $addr = $this->order->billingAdderss;
        return (new MailMessage)
            ->subject("New Order #{$this->order->name}")
            ->from('notification@israa-store.ps', 'ISRAA')
            ->greeting("Hi {$notifiable->name}")
            ->line("A new order #{$this->order->number} created by {$addr->name} from {$addr->country_name}")
            ->action('View Order', url('/admin/dashboard'))
            ->line('Thank you for using our application!');
    }
    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAdderss;
        return [
            'body' => "A new order #{$this->order->number} ", //created by {$addr->name} from {$addr->country_name}",
            'icon' => 'fas fa-envelope',
            'url' => url('/admin/dashboard'),
        ];
    }
    public function toBroadcast($notifiable)
    {
        $addr = $this->order->billingAdderss;
        return new BroadcastMessage([
            'body' => "A new order #{$this->order->number} created by {$addr->name} from {$addr->country_name}", //created by {$addr->name} from {$addr->country_name}",
            'icon' => 'fas fa-envelope',
            'url' => url('/'),
        ]);
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
