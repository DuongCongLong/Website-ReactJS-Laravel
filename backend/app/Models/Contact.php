<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';

    // Các cột có thể được gán giá trị từ frontend
    protected $fillable = ['name', 'email', 'message','user_id']; 
}