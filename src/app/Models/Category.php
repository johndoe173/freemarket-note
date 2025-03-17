<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // 🔹 カテゴリーに関連する商品を取得する
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id')->withTimestamps();
    }
}

