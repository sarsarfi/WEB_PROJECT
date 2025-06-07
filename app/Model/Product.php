<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products'; 
    protected $fillable = ['name', 'description', 'price', 'image'];

    public $timestamps = true;

    // مثال ارتباط با کاربر (اگر بخوای)
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
