<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CheckoutInformation;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'address1' => 'string|required',
            'address2' => 'string|nullable',
            'coupon' => 'nullable|numeric',
            'phone' => 'numeric|required',
            'post_code' => 'string|nullable',
            'email' => 'string|required|email',
            'shipping' => 'required|exists:shippings,id',
        ], [
            'first_name.required' => 'Nama depan wajib diisi.',
            'last_name.required' => 'Nama belakang wajib diisi.',
            'address1.required' => 'Alamat baris pertama wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.numeric' => 'Nomor telepon harus berupa angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'shipping.required' => 'Opsi pengiriman wajib dipilih.',
            'shipping.exists' => 'Opsi pengiriman tidak valid.',
            'coupon.numeric' => 'Kupon harus berupa angka.',
        ]);

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Keranjang kosong!');
            return back();
        }

        $checkoutInfo = CheckoutInformation::where('user_id', auth()->user()->id)->first();

        if ($checkoutInfo) {
            $checkoutInfo->user_id = auth()->user()->id;
            $checkoutInfo->first_name = $request->first_name;
            $checkoutInfo->last_name = $request->last_name;
            $checkoutInfo->email = $request->email;
            $checkoutInfo->phone_number = $request->phone;
            $checkoutInfo->country = $request->country;
            $checkoutInfo->address_line1 = $request->address1;
            $checkoutInfo->address_line2 = $request->address2;
            $checkoutInfo->postal_code = $request->post_code;
            $checkoutInfo->save();
        } else {
            $checkoutInfo = new CheckoutInformation();
            $checkoutInfo->user_id = auth()->user()->id;
            $checkoutInfo->first_name = $request->first_name;
            $checkoutInfo->last_name = $request->last_name;
            $checkoutInfo->email = $request->email;
            $checkoutInfo->phone_number = $request->phone;
            $checkoutInfo->country = $request->country;
            $checkoutInfo->address_line1 = $request->address1;
            $checkoutInfo->address_line2 = $request->address2;
            $checkoutInfo->postal_code = $request->post_code;
            $checkoutInfo->save();
        }

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['shipping_id'] = $request->shipping;

        $shipping = Shipping::where('id', $order_data['shipping_id'])->pluck('price');
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();

        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }

        $order_data['total_amount'] = Helper::totalCartPrice() + ($shipping[0] ?? 0) - (session('coupon')['value'] ?? 0);

        $order_data['status'] = "new";
        $order_data['payment_method'] = $request->payment_method;
        $order_data['payment_status'] = $request->payment_method === 'paypal' ? 'paid' : 'Unpaid';

        $order->fill($order_data);
        $order->save();

        // Update keranjang
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

        // Kirim notifikasi admin
        $admin = User::where('role', 'admin')->first();
        $details = [
            'title' => 'Pesanan baru telah dibuat',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt',
        ];
        Notification::send($admin, new StatusNotification($details));

        // Bersihkan sesi
        session()->forget('cart');
        session()->forget('coupon');

        // Proses pembayaran (contoh Midtrans)
        if ($request->payment_method === 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        } elseif ($request->payment_method === 'cod') {
            request()->session()->flash('success', 'Pesanan berhasil dibuat');
            return redirect()->route('home');
        } else {
            $snapToken = $this->generateSnapToken($order);
            $cartItems = Cart::with('product')
                ->where('order_id', $order->id)
                ->get();
            return view('frontend.pages.payment', compact('snapToken', 'order', 'cartItems'));
        }
    }

    public function generateSnapToken($order)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->user()->id)
            ->where('order_id', $order->id)
            ->get();

        $itemDetails = $cartItems->map(function ($cart) {
            return [
                'id' => $cart->product_id,
                'price' => $cart->price,
                'quantity' => $cart->quantity,
                'name' => substr($cart->product->title, 0, 50),
            ];
        })->toArray();

        if ($order->shipping_id) {
            $shipping = Shipping::find($order->shipping_id);
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => $shipping->price,
                'quantity' => 1,
                'name' => 'Shipping Cost',
            ];
        }

        $grossAmount = collect($itemDetails)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

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

        return \Midtrans\Snap::getSnapToken($params);
    }

    public function pay($id)
    {
        $order = Order::findOrFail($id);

        if ($order->payment_status == 'paid') {
            return redirect()->back()->with('success', 'Pembayaran sudah selesai.');
        }

        // Proses ulang pembayaran, contoh dengan Midtrans
        $snapToken = $this->generateSnapToken($order);

        // Ambil item dalam keranjang
        $cartItems = Cart::with('product')->where('order_id', $order->id)->get();

        // Tampilkan halaman pembayaran ulang
        return view('frontend.pages.payment', compact('snapToken', 'order', 'cartItems'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Pesanan berhasil diperbarui');
        } else {
            request()->session()->flash('error', 'Error ketika memperbarui pesanan');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                request()->session()->flash('success', 'Pesanan berhasil dihapus');
            } else {
                request()->session()->flash('error', 'Pesanan tidak dapat dihapus');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Pesanan tidak ditemukan');
            return redirect()->back();
        }
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();

        $data = $request->all();

        $validate = Validator::make($data, [
            'order_number' => 'required',
        ], [
            'order_number.required' => 'Wajib diisi',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                // request()->session()->flash('success', 'Your order has been placed. please wait.');
                request()->session()->flash('success', 'Pesanan Anda telah ditempatkan. Harap tunggu.');
                return redirect()->route('home');
            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Pesanan Anda sedang diproses. Harap tunggu.');
                return redirect()->route('home');
            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Pesanan Anda berhasil dikirim.');
                return redirect()->route('home');
            } else {
                request()->session()->flash('error', 'Pesanan Anda dibatalkan. Silakan coba lagi');
                return redirect()->route('home');
            }
        } else {
            request()->session()->flash('error', 'Nomor pesanan tidak valid, silakan coba lagi');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                $m = intval($month);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            // $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $monthName = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
