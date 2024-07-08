<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['category_id', 'title', 'slug', 'summary', 'description', 'price', 'discount', 'status', 'photo', 'stock', 'is_featured'];

    // public function cat_info(){
    //     return $this->hasOne('App\Models\Category','id','cat_id');
    // }
    // public function sub_cat_info(){
    //     return $this->hasOne('App\Models\Category','id','child_cat_id');
    // }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public static function getAllProduct()
    {
        return Product::with('category')->orderBy('id', 'desc')->paginate(10);
    }

    public function rel_prods()
    {
        return $this->hasMany('App\Models\Product', 'cat_id', 'cat_id')->where('status', 'active')->orderBy('id', 'DESC')->limit(8);
    }
    public function getReview()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }
    public static function getProductBySlug($slug)
    {

        return Product::with(['getReview'])->where('slug', $slug)->first();
    }
    public static function countActiveProduct()
    {
        $data = Product::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }
}
