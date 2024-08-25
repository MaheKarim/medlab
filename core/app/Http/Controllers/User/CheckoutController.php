<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use App\Traits\OrderConfirmation;

class CheckoutController extends Controller
{
    use OrderConfirmation;

    public function checkout(Request $request)
    {
        $pageTitle = 'Checkout';
        $user = auth()->user();
        $userId = $user->id;

        $subtotal = $this->validateCartAndCalculateSubtotal($userId);

        if ($subtotal == 0) {
            return redirect(route('cart.cart'));
        }

        $data['subtotal'] = $subtotal;
        $data['total'] = $subtotal;

        session()->put('total', $data['subtotal']);
        $shippingMethod = ShippingMethod::active()->get();

        return view('Template::checkout', compact('pageTitle', 'data', 'shippingMethod', 'user'));
    }

    public function order(Request $request)
    {
        $request->validate([
            'firstname'       => 'required',
            'lastname'        => 'required',
            'mobile'          => 'required',
            'email'           => 'required',
            'address'         => 'required',
            'state'           => 'required',
            'city'            => 'required',
            'zip'             => 'required',
            'shipping_method' => 'required|integer',
            'payment_type'    => 'required|integer|in:1,2',
        ]);

        $user = auth()->user();
        $subtotal = $this->validateCartAndCalculateSubtotal($user->id);

        if ($subtotal === false) {
            return back()->withInput();
        }

        $shipping = ShippingMethod::where('id', $request->shipping_method)->active()->first();

        if (!$shipping) {
            $notify[] = ['error', 'Shipping method unable to locate.'];
            return back()->withNotify($notify)->withInput();
        }

        $grandTotal = $subtotal + $shipping->price;

        $address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];

        $order = new Order();
        $order->user_id = $user->id;
        $order->order_no = getTrx();
        $order->subtotal = $subtotal;
        $order->shipping_charge = $shipping->price;
        $order->total = $grandTotal;
        $order->shipping_method_id = $shipping->id;
        $order->address = json_encode($address);
        $order->payment_type = $request->payment_type;
        $order->save();

        static::confirmOrder($order);

        if ($request->payment_type == Status::PAYMENT_ONLINE) {
            return redirect()->route('user.deposit.index', $order->id);
        }

        $notify[] = ['success', 'Order submitted successfully.'];
        return redirect()->route('user.order.details', $order->id)->withNotify($notify);
    }

    protected function validateCartAndCalculateSubtotal($userId)
    {
        $carts = Cart::where('user_id', $userId)->with('product')->get();
        $subtotal = 0;

        foreach ($carts as $cart) {
            $product = Product::active()->where('id', $cart->product->id)->first();

            if (!$product) {
                $cart->delete();
                return false;
            }

            if ($product->quantity < $cart->quantity) {
                $cart->delete();
                return false;
            }

            $price = showDiscountPrice($product->price, $product->discount, $product->discount_type);
            $subtotal += $price * $cart->quantity;
        }

        return $subtotal;
    }
}
