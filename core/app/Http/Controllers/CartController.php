<?php

namespace App\Http\Controllers;

use App\Constants\Status;
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

    public function getCartTotal()
    {
        $userId    = auth()->user()->id ?? null;
        if ($userId != null) {
            $totalCart = Cart::where('user_id', $userId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->get();
        } else {
            $sessionId = session()->get('session_id');

            $totalCart = Cart::where('session_id', $sessionId)
                ->with(['product'])
                ->whereHas('product', function ($q) {
                    return $q->whereHas('category');
                })
                ->get();
        }
        session()->put('total', ['total' => $totalCart]);

        return $totalCart->count();
    }

    public function cart()
    {
        $pageTitle = 'Cart';
        $userId = auth()->user()->id ?? null;
        $sessionId = session()->get('session_id');

        $cartQuery = Cart::with('product');

        if ($userId) {
            $cartQuery->where('user_id', $userId);
        } else {
            $cartQuery->where('session_id', $sessionId);
        }

        $carts = $cartQuery->get()->filter(function ($cart) {
            $product = $cart->product;
            if (!$product || $product->status == Status::DISABLE || $product->quantity == 0) {
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
            'product_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $userId = auth()->id();

        if ($userId) {
            $cart = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();
            $cart->delete();
        } else {
            $sessionId = session()->get('session_id');

            if ($sessionId == null) {
                session()->put('session_id', session()->getId());
                $sessionId = session()->get('session_id');
            }
            // If $sessionId not match then session_id not found
            if ($sessionId != session()->get('session_id')) {
                return response()->json(['error' => 'Session not found!']);
            }

            $cart = Cart::where('session_id', $sessionId)->where('product_id', $request->product_id)->first();
            $cart->delete();
        }

        return response()->json(['success' => 'Product was successfully removed.']);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|gt:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $product = Product::active()->find($request->product_id);
        $userId  = auth()->id();

        if ($request->quantity > $product->quantity) {
            return response()->json(['error' => 'Requested quantity is not available in our stock.']);
        }

        if ($userId) {
            $cart = Cart::where('user_id', $userId)->where('product_id', $request->product_id)->first();
            $cart->quantity = $request->quantity;
            $cart->save();
        } else {
            $sessionId = session()->get('session_id');
            $cart = Cart::where('session_id', $sessionId)->where('product_id', $request->product_id)->first();
            $cart->quantity = $request->quantity;
            $cart->save();
        }

        return response()->json(['success' => 'Cart was successfully updated.']);
    }
}
