<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use GlobalStatus;

    public $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function insertUserToCart($userId, $sessionId)
    {
        static::where('session_id', $sessionId)->get();
        static::where('session_id', $sessionId)->update(['user_id'=>$userId]);
    }

}
