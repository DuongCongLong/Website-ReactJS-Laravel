<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = 'product_reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review_text',
        'created_by',
        'updated_by',
        'status',
        'image',
        'is_violation',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
