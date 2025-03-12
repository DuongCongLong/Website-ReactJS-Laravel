<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $primaryKey = 'product_id';
    protected $fillable = ['name', 'price', 'description', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }


    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}