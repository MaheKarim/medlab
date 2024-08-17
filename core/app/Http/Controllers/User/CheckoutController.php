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
        $userId = auth()->user()->id;


        $subtotal = $this->cartSubTotal($userId);

        if ($subtotal == 0) {
            abort(404);
        }

        $data['subtotal'] = $subtotal;
        $data['total'] = $subtotal;

        session()->put('total', $data['subtotal']);
        $shippingMethod = ShippingMethod::active()->get();
        $user = auth()->user();

        return view('Template::checkout', compact('pageTitle', 'data',  'shippingMethod', 'user'));
    }


    public function order(Request $request)
    {
        $request->validate([
            'firstname'       => 'required',
            'lastname'        => 'required',
            'mobile'          => 'required',
            'email'           => 'required',
            'country_name'    => 'required',
            'address'         => 'required',
            'state'           => 'required',
            'city'            => 'required',
            'zip'             => 'required',
            'shipping_method' => 'required|integer',
        ]);

        $user     = auth()->user();
        $subtotal = $this->cartSubTotal($user->id);
        $shipping = ShippingMethod::where('id', $request->shipping_method)->where('status', Status::ENABLE)->first();

        if (!$shipping) {
            $notify[] = ['error', 'Shipping method unable to locate.'];
            return back()->withNotify($notify)->withInput();
        }

        $grandTotal = $subtotal + $shipping->price;
//        $total = session()->get('total');

//        if ($total) {
//            $grandTotal = $grandTotal - 0;
//        }

        $address = [
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
//            'country_name' => $request->country,
            'city'    => $request->city,
        ];

        $order                     = new Order();
        $order->user_id            = $user->id;
        $order->order_no           = getTrx();
        $order->subtotal           = $subtotal;
        $order->shipping_charge    = $shipping->price;
        $order->total              = $grandTotal;
        $order->shipping_method_id = $shipping->id;
        $order->address            = json_encode($address);
        $order->payment_type       = $request->payment_type;
        $order->save();

        if ($request->payment_type == Status::PAYMENT_ONLINE) {
            return redirect()->route('user.deposit.index', $order->id);
        }

        static::confirmOrder($order);

        $notify[] = ['success', 'Order successfully completed.'];
        return redirect()->route('user.home', $order->id)->withNotify($notify);
    }

    protected function cartSubTotal($user_id)
    {
        $carts = Cart::where('user_id', $user_id)->with('product')->get();
        $total = [0];

        foreach ($carts as $cart) {
            $sumPrice = 0;
            $product  = Product::active()->where('id', $cart->product->id)->first();
            $price    = productPrice($product);

            $sumPrice = $sumPrice + ($price * $cart->quantity);
            $total[]  = $sumPrice;
        }

        $subtotal = array_sum($total);
        return $subtotal;
    }
}
