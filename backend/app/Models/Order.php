<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id', 'totalorder', 'payment_method_id', 'shipping_method_id', 
        'shipping_status_id', 
        'address', 'status', 'created_by', 'updated_by'
    ];
    
    // Quan hệ với bảng `OrderDetail`
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Quan hệ với bảng `User`
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_method_id');
    }

    // Định nghĩa mối quan hệ với bảng Transactions
    public function transaction()
{
    return $this->hasOne(Transaction::class, 'order_id', 'order_id'); // Giả sử 'order_id' là khóa ngoại trong bảng transactions
}


    // Định nghĩa mối quan hệ với bảng ShippingStatus
    public function shippingStatus()
    {
        return $this->belongsTo(shippingStatus::class, 'shipping_status_id');
    }

}