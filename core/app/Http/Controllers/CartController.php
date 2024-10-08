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
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }

        $product = Product::active()->find($request->product_id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => "Product not found"
            ]);
        }

        if ($product->quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => "Product stock is not available!"
            ]);
        }

        $userId = auth()->user()->id ?? null;

        $sessionId = session()->get('session_id');
        if ($sessionId == null) {
            session()->put('session_id', session()->getId());
            $sessionId = session()->get('session_id');
        }

        if ($userId != null) {

            $cart = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->first();
        } else {
            $cart = Cart::where('session_id', $sessionId)
                ->where('product_id', $request->product_id)
                ->first();
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

        if ($userId != null) {
            $totalCartItems = Cart::where('user_id', $userId)->with(['product'])
                ->count();
        } else {
            $totalCartItems = Cart::where('session_id', $sessionId)->with(['product'])
                ->count();
        }
        session()->put('cart', $cart);
        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'totalCartItem' => $totalCartItems
        ]);
    }

    public function cart()
    {
        $pageTitle = 'Cart';
        $userId = auth()->user()->id ?? null;
        $sessionId = session()->get('session_id');

        $cartQuery = Cart::with(['product' => function ($query) {
            $query->available();
        }]);

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }

        $carts = $cartQuery->get()->filter(function ($cart) {
            $product = $cart->product;
            if (!$product) {
                $cart->delete();
                return false;
            }
            return true;
        });

        return view('Template::cart_view', compact('pageTitle', 'carts'));
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|array',
            'product_id.*' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $userId = auth()->id();
        $productIds = $request->product_id;

        if ($userId) {
            Cart::where('user_id', $userId)->whereIn('product_id', $productIds)->delete();
        } else {
            $sessionId = session()->get('session_id');

            if ($sessionId == null) {
                session()->put('session_id', session()->getId());
                $sessionId = session()->get('session_id');
            }

            if ($sessionId != session()->get('session_id')) {
                return response()->json(['error' => 'Session not found!']);
            }

            Cart::where('session_id', $sessionId)->whereIn('product_id', $productIds)->delete();
        }

        return response()->json(['success' => 'Product were successfully removed.']);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|gte:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $product = Product::active()->find($request->product_id);

        $userId  = auth()->id();

        if ($request->quantity > $product->quantity) {
            return response()->json(['error' => 'Requested quantity is not available in our stock.']);
        }

        $qty=$request->quantity;

        if ($userId) {

            $cart = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();
            $cart->quantity=$qty;
            $cart->save();
            $subtotal=$cart->quantity*$product->price;
        } else {
            $sessionId = session()->get('session_id');
            $cart = Cart::where('session_id', $sessionId)->where('product_id', $request->product_id)->first();
            $cart->quantity=$qty;
            $cart->save();
            $subtotal=$cart->quantity*$product->price;
        }

        $totalCart = $this->getCartTotal();

        return response()->json([
            'success' => true,
            'message' => 'Cart was successfully updated',
            'total_cart_count' => $totalCart,
            'subtotal' => showAmount($subtotal),
            'quantity' => $cart->quantity
        ]);
    }

    public function getCartTotal()
    {
        $userId    = auth()->user()->id ?? null;
        if ($userId != null) {
            $totalCart = Cart::where('user_id', $userId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->count();
        } else {
            $sessionId = session()->get('session_id');

            $totalCart = Cart::where('session_id', $sessionId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->count();
        }
        session()->put('total', ['total' => $totalCart]);

        return $totalCart;
    }
}
