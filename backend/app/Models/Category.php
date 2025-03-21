<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id'); // Thay 'category_id' bằng khóa ngoại thực tế trong bảng `products`
    }
}
