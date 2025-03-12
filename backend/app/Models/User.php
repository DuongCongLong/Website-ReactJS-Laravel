<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table='users';
    protected $fillable = [
        'name', 
        'email', 
        'password'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    public function cart()
    {
        return $this->hasMany(Cart::class, 'user_id'); // 'user_id' là khóa ngoại trong bảng cart_items
    }


    // use HasFactory, Notifiable;
    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'user_id');
    // }
    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    // protected $table='users';
    // protected $primaryKey = 'user_id';
    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var array<int, string>
    //  */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
}
