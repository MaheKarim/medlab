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

    public static function insertUserToCart($user_id, $session_id)
    {
        $cart = self::where('session_id', $session_id)->get();

        self::where('session_id', $session_id)->update(['user_id'=>$user_id]);
    }

}
