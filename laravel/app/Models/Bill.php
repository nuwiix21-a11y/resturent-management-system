<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['order_id', 'subtotal', 'discount', 'tax', 'total', 'payment_status'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax'      => 'decimal:2',
        'total'    => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
