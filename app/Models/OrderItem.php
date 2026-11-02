<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'service_id', 'name', 'price', 'quantity', 'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class)->withDefault([
            'name'     => $this->name,   // fallback ke nama yang tersimpan di order_items
            'category' => '—',
        ]);
    }
}