<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Midtrans;
use Midtrans\Transaction;
use App\Http\Controllers\OrderController;

class PaymentController extends Controller
{
    public function retryPayment($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status === 'failed') {
            return redirect()->route('home')->with('error', 'Pembayaran sudah gagal. Silahkan hubungi support.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('home')->with('error', 'Pesanan ini sudah dibayar.');
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->user()->id)
            ->where('order_id', $order->id)
            ->get();

        $itemDetails = $cartItems->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product->title,
            ];
        })->toArray();

        // Biaya pengiriman
        $shippingCost = 0;
        if ($order->shipping_id) {
            $shipping = \DB::table('shippings')->where('id', $order->shipping_id)->first();
            $shippingCost = $shipping->price;
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => $shippingCost,
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ];
        }

        // Total pembayaran
        $grossAmount = collect($itemDetails)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->first_name,
                'last_name' => $order->last_name,
                'email' => $order->email,
                'phone' => $order->phone,
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return view('frontend.pages.payment', compact('snapToken', 'order', 'cartItems'));
        } catch (\Exception $e) {
            $order->payment_status = 'failed';
            $order->save();
            return redirect()->route('home')->with('error', 'Gagal membuat ulang pembayaran: ' . $e->getMessage());
        }
    }

    public function handleCallback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $signatureKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;

        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($transactionStatus == 'settlement') {
            $order->payment_status = 'paid';
            $order->payment_time = Carbon::now();
            $order->save();
        } elseif (in_array($transactionStatus, ['expire', 'cancel'])) {
            $order->payment_status = 'failed';
            $order->save();
        }

        return response()->json(['message' => 'Callback handled successfully'], 200);
    }
}
