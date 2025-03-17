<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'image', 'user_id', 'is_sold', 'category','condition',
    ];

    // 🔹 いいね機能のリレーション
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'product_id', 'user_id')->withTimestamps();
    }

    // 🔹 コメントのリレーション
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    // 🔹 カテゴリーのリレーション
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id')->withTimestamps();
    }

    protected $casts = [
    'category' => 'array', // JSON を自動的に配列として扱う
    ];
}

