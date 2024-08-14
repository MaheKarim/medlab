<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'product_id' => 'required',
            'quantity' => 'required'
        ]);


        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }
        $product = Product::active()->find($request->product_id);

        if(!$product){
            return response()->json([
                'status' => false,
                'message' => "Product not found"
            ]);
        }
        $userId = auth()->user()->id ?? null;


        $sessionId = session()->get('session_id');
        if ($sessionId == null) {
            session()->put('session_id', uniqid());
            $sessionId = session()->get('session_id');
        }

        if ($userId != null) {
            $cart = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();
        } else {
            $cart = Cart::where('session_id', $sessionId)->where('product_id', $request->product_id)->first();
        }

        // Check Product Quantity
        if ($product->quantity < $request->quantity) {
            return response()->json([
                'status' => false,
                'message' => "Product stock is not available!"
            ]);

        }

        if ($cart) {
            $cart->update([
                'quantity' => $cart->quantity + $request->quantity
            ]);
        } else {
            $cart = new Cart();
            $cart->user_id = $userId;
            $cart->session_id = $sessionId;
            $cart->product_id = $request->product_id;
            $cart->quantity = $request->quantity;
            $cart->save();
        }



        $totalCartItem=5;
        $notify[] = ['success', 'Product added to cart successfully!'];
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'total_cart_item' => $totalCartItem
        ]);

    }


    public function getCartTotal()
    {
        $userId    = auth()->user()->id ?? null;
        if ($userId != null) {
            $total_cart = Cart::where('user_id', $userId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->get();
        } else {
            $sessionId = session()->get('session_id');

            $total_cart = Cart::where('session_id', $sessionId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->get();
        }
        return $total_cart->count();
    }
}
