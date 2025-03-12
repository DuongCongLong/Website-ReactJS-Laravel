<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $table='shippings';
    protected $primaryKey = 'shipping_id';
    // Định nghĩa mối quan hệ ngược lại với bảng Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_id');
    }
}
