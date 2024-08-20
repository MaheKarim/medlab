<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

trait OrderConfirmation
{
    public static function confirmOrder($order) {
        $user  = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();

        $orderDetailsData   = [];
        $productStockUpdate = [];
        $saleCountUpdate    = [];
        $orderDetails       = "";

        foreach ($carts as $cart) {
            $price = showDiscountPrice($cart->product->price, $cart->product->discount, $cart->product->discount_type);
            $orderDetailsData[] = [
                'order_id'   => $order->id,
                'product_id' => $cart->product_id,
                'quantity'   => $cart->quantity,
                'price'      => $price,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $productStockUpdate[$cart->product_id] = $cart->quantity;
            $saleCountUpdate[$cart->product_id] = $cart->quantity;
            // Order Details as String for Notification (No Array)
            $orderDetails .= $cart->product->name . " x " . $cart->quantity . " - <b>" . showAmount($price) . "</b>\n";
        }

        if (!empty($orderDetailsData)) {
            OrderDetail::insert($orderDetailsData);
        }

        if ($carts->isNotEmpty()) {
            Cart::whereIn('id', $carts->pluck('id'))->delete();
        }

        if (!empty($productStockUpdate)) {
            $updateStockValues = [];
            $updateSaleValues = [];

            foreach ($productStockUpdate as $id => $quantity) {
                $updateStockValues[] = "WHEN id = $id THEN quantity - $quantity";
            }

            foreach ($saleCountUpdate as $id => $quantity) {
                $updateSaleValues[] = "WHEN id = $id THEN sale_count + $quantity";
            }

            $updateStockValues = implode(' ', $updateStockValues);
            $updateSaleValues = implode(' ', $updateSaleValues);

            // Update stock and sale_count
            Product::whereIn('id', array_keys($productStockUpdate))->update([
                'quantity' => DB::raw("CASE $updateStockValues ELSE quantity END"),
                'sale_count' => DB::raw("CASE $updateSaleValues ELSE sale_count END")
            ]);
        }

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'Order successfully placed.';
        $adminNotification->click_url = urlPath('admin.order.details',$order->id);
        $adminNotification->save();

        notify($user, 'ORDER_COMPLETE', [
            'user_name'       => $user->username,
            'order_no'        => $order->order_no,
            'subtotal'        => showAmount($order->subtotal, currencyFormat: false),
            'shipping_charge' => showAmount($order->shipping_charge, currencyFormat: false),
            'total'           => showAmount($order->total, currencyFormat: false),
            'order_details'   => $orderDetails,
        ]);
    }

    protected static function transactionCreate($order, $user, $deposit) {
        $order->payment_status = Status::ORDER_PAYMENT_SUCCESS;
        $order->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $order->total;
        $transaction->charge       = $deposit->charge;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Order confirmation via '.$deposit->gatewayCurrency()->name;
        $transaction->trx          = $order->order_no;
        $transaction->remark       = 'Payment';
        $transaction->save();

        notify($user, 'PAYMENT_COMPLETE', [
            'user_name'       => $user->username,
            'subtotal'        => showAmount($order->subtotal, currencyFormat: false),
            'shipping_charge' => showAmount($order->shipping_charge, currencyFormat: false),
            'total'           => showAmount($order->total, currencyFormat: false),
            'currency'        => gs('cur_text'),
            'order_no'        => $order->order_no,
            'method'          => $deposit->gatewayCurrency()->name,
            'charge' => showAmount($deposit->charge, currencyFormat: false),
        ]);
    }

    protected static function orderCancel($order) {
        $order->payment_status = Status::ORDER_PAYMENT_CANCEL;
        $order->save();

        $productStockUpdate = [];

        foreach ($order->orderDetail as $detail) {
            $productStockUpdate[$detail->product_id] = $detail->quantity;
        }

        if (!empty($productStockUpdate)) {
            $updateValues = [];

            foreach ($productStockUpdate as $id => $quantity) {
                $updateValues[] = "WHEN id = $id THEN quantity + $quantity";
            }

            $updateValues = implode(' ', $updateValues);
            Product::whereIn('id', array_keys($productStockUpdate))->update([
                'quantity' => DB::raw("CASE $updateValues ELSE quantity END")
            ]);
        }
    }

    protected static function createCart($user) {
        $carts = session()->get('cart');

        foreach ($carts as $key => $cart) {
            $createCart = new Cart();
            $createCart->user_id = $user->id;
            $createCart->product_id = $key;
            $createCart->quantity = $cart['quantity'];
            $createCart->save();
        }
    }
}
