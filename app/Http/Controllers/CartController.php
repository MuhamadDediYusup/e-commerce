<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CheckoutInformation;
use Illuminate\Support\Str;
use Helper;

class CartController extends Controller
{
    protected $product = null;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart(Request $request)
    {
        if (empty($request->slug)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        // jika user belum login maka akan diarahkan ke login
        if (!Auth::check()) {
            return redirect('user/login');
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Stok tidak mencukupi!.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stok tidak mencukupi!.');
            $cart->save();
        }
        request()->session()->flash('success', 'Produk berhasil ditambahkan ke keranjang');
        return back();
    }

    public function singleAddToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect('user/login');
        }

        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);


        $product = Product::where('slug', $request->slug)->first();
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Melebihi stok, Anda dapat menambahkan produk lain.');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            request()->session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();

        if ($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1]) + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error', 'Stok tidak mencukupi!.');

            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price - ($product->price * $product->discount) / 100);
            $cart->quantity = $request->quant[1];
            $cart->amount = ($product->price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error', 'Stok tidak mencukupi!.');
            $cart->save();
        }
        request()->session()->flash('success', 'Produk berhasil ditambahkan ke keranjang');
        return back();
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success', 'Keranjang berhasil dihapus');
            return back();
        }
        request()->session()->flash('error', 'Error, Silahkan coba lagi');
        return back();
    }

    public function cartUpdate(Request $request)
    {
        try {
            if ($request->quant && $request->qty_id) {
                $error = [];
                $success = '';
                $cart_amount = 0;

                foreach ($request->qty_id as $index => $id) {
                    $quant = $request->quant[$id] ?? null;
                    $cart = Cart::find($id);

                    if (!$cart) {
                        $error[] = "Keranjang dengan ID $id tidak ditemukan!";
                        continue;
                    }

                    if (!is_numeric($quant) || $quant <= 0) {
                        $error[] = "Jumlah untuk keranjang ID $id tidak valid!";
                        continue;
                    }

                    if ($cart->product->stock < $quant) {
                        $error[] = "Jumlah untuk keranjang ID $id melebihi stok!";
                        if ($request->ajax()) {
                            return response()->json(['error' => "Jumlah untuk keranjang ID $id melebihi stok!"], 400);
                        }
                        return back()->with('error', "Jumlah untuk keranjang ID $id melebihi stok!");
                    }

                    $cart->quantity = ($cart->product->stock > $quant) ? $quant : $cart->product->stock;
                    if ($cart->product->stock <= 0) {
                        $error[] = "Stok produk untuk keranjang ID $id habis!";
                        continue;
                    }

                    $after_price = ($cart->product->price - ($cart->product->price * $cart->product->discount) / 100);
                    $cart->amount = $after_price * $quant;
                    $cart->save();

                    $cart_amount = $cart->amount;
                    $success = 'Keranjang berhasil diupdate!';
                }

                $subtotal = Cart::where('user_id', auth()->user()->id)
                    ->where('order_id', null)
                    ->sum('amount');

                $total = $subtotal;
                if (session()->has('coupon')) {
                    $total = $total - session('coupon')['value'];
                }

                if ($request->ajax()) {
                    return response()->json([
                        'success' => $success,
                        'cart_amount' => $cart_amount,
                        'subtotal' => $subtotal,
                        'total' => $total,
                        'errors' => $error
                    ]);
                }

                return back()->withErrors($error)->with('success', $success);
            } else {
                $error = 'Data keranjang atau jumlah tidak valid!';
                \Log::error('Invalid request data: ' . json_encode($request->all()));
                if ($request->ajax()) {
                    return response()->json(['error' => $error], 400);
                }
                return back()->with('error', $error);
            }
        } catch (\Exception $e) {
            \Log::error('Cart Update Error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'Terjadi kesalahan server: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan server!');
        }
    }

    public function checkout(Request $request)
    {

        $checkoutInfo = CheckoutInformation::where('user_id', auth()->user()->id)->first();

        return view('frontend.pages.checkout', compact('checkoutInfo'));
    }
}
