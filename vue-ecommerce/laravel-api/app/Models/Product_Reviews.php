<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Reviews extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';

    protected $guarded = ['id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }

}
