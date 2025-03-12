<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingStatus extends Model
{
    use HasFactory;

    // Đặt tên bảng (nếu bảng của bạn không theo chuẩn tên bảng tự động)
    protected $table = 'shipping_statuses';

    // Đặt tên cột khóa chính (nếu không phải 'id')
    protected $primaryKey = 'id';
    // Quan hệ với model khác (nếu có)
    public function orders()
    {
        return $this->hasMany(Order::class, 'shipping_status_id');
    }
}
