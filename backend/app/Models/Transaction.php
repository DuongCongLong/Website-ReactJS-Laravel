<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table='transactions';
    protected $primaryKey = 'transaction_id';
    public function orders()
    {
        return $this->hasMany(Order::class, 'transaction_id');
    }
}
