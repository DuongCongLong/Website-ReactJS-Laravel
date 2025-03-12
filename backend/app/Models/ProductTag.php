<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tag';

    // Mối quan hệ với bảng 'products' thông qua bảng trung gian 'product_tag'
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'tag_id', 'product_id');
    }
}
