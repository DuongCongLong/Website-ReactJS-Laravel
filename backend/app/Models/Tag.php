<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    // Nếu bảng của bạn không sử dụng tên mặc định (số nhiều), bạn có thể chỉ định tên bảng
    protected $table = 'tags'; // Chỉnh sửa nếu bảng của bạn có tên khác

    // Mối quan hệ nhiều-nhiều với bảng 'products' thông qua bảng trung gian 'product_tag'
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'tag_id', 'product_id');
    }
}
