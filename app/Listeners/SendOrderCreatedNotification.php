<?php

namespace App\Listeners;



use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\OrderCreatedNotification;
use App\Events\OrderCreated;
use App\Models\User;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        //
        $order = $event->order;
        $user = User::where('store_id', $order->store_id)->first();
        $user->notify(new OrderCreatedNotification($order)); //This $user Is $notifiable In OrderCreatedNotification Class
        // If I need send notification to multi notifaiables
        // $user = User::where('store_id', $order->store_id)->get();
        // Notification::send($user,new SendOrderCreatedNotification($order));
    }
}
