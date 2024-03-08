<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Order extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'store_id', 'user_id', 'payment_method', 'status', 'payment_status'
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name' => 'Guest Customer']);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)
            ->as('order_item')
            ->withPivot(['product_name', 'price', 'quantity', 'options']);
    }
    public function addresses()        // Billing & Shipping Addresses
    {
        return $this->hasMany(OrderAddress::class);
    }
    public function billingAdderss()  // Return just Billing Address
    {     // This Method Return Model
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', '=', 'billing');
        // This Method Return Collection
        //  return $this->addresses()->where('type', '=', 'billing');
    }
    public function shippingAdderss() // Return just Shipping Address
    {
        return $this->hasOne(OrderAddress::class, 'order_id', 'id')->where('type', '=', 'shipping');
    }

    protected static function booted()
    {
        static::creating(function (Order $order) {
            // Order Format 20220001 | 20220002
            $order->number = Order::getNextOrderNumber();
        });
    }
    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }
    public static function getNextOrderNumber()
    {   // How I Create This Number  20220001
        // SELECT MAX(number) FROM orders =>  Order::max('number')
        $year = Carbon::now()->year;
        $number = Order::whereYear('created_at', $year)->max('number');
        if ($number) {
            return $number + 1;
        }
        return $year . '0001';
    }
}
