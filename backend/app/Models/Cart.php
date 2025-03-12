<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts'; 
    protected $primaryKey = 'id';
    // Các thuộc tính có thể mass-assignable
    protected $fillable = ['product_id', 'user_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
}
