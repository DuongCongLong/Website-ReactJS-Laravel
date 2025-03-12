<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details'; // Tên bảng trong database, nếu khác thì thay đổi tên cho đúng
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price']; // Các cột có thể điền vào
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}