<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function sub_category(){
        return $this->belongsTo(Sub_category::class);
    }
    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }
    public function order_item(){
        return $this->hasMany(Order_item::class);
    }
    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }
    public function Inventory(){
        return $this->hasOne(Inventory::class);
    }
    public function product_reviews(){
        return $this->hasMany(Product_Reviews::class);
    }
    public function product_price(){
        return $this->hasOne(ProductPrice::class);
    }
    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');
    }
}
