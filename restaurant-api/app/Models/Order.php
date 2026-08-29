<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'table_number', 'type', 'status', 'notes', 'total'];

    protected $casts = ['total' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
