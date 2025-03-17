<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // ユーザーがいない場合は作成
        $user = User::first() ?? User::factory()->create();

        // 商品データのリスト
        $products = [
            ['name' => '腕時計', 'price' => 15000, 'description' => 'スタイリッシュなデザインのメンズ腕時計', 'condition' => '良好', 'image' => 'products/Armani+Mens+Clock.jpg'],
            ['name' => 'HDD', 'price' => 5000, 'description' => '高速で信頼性の高いハードディスク', 'condition' => '目立った傷や汚れなし', 'image' => 'products/HDD+Hard+Disk.jpg'],
            ['name' => '玉ねぎ3束', 'price' => 300, 'description' => '新鮮な玉ねぎ3束のセット', 'condition' => 'やや傷や汚れあり', 'image' => 'products/iLoveIMG+d.jpg'],
            ['name' => '革靴', 'price' => 4000, 'description' => 'クラシックなデザインの革靴', 'condition' => '状態が悪い', 'image' => 'products/Leather+Shoes+Product+Photo.jpg'],
            ['name' => 'ノートPC', 'price' => 45000, 'description' => '高性能なノートパソコン', 'condition' => '良好', 'image' => 'products/Living+Room+Laptop.jpg'],
            ['name' => 'マイク', 'price' => 8000, 'description' => '高音質のレコーディング用マイク', 'condition' => '目立った傷や汚れなし', 'image' => 'products/Music+Mic+4632231.jpg'],
            ['name' => 'ショルダーバッグ', 'price' => 3500, 'description' => 'おしゃれなショルダーバッグ', 'condition' => 'やや傷や汚れあり', 'image' => 'products/Purse+fashion+pocket.jpg'],
            ['name' => 'タンブラー', 'price' => 500, 'description' => '使いやすいタンブラー', 'condition' => '状態が悪い', 'image' => 'products/Tumbler+souvenir.jpg'],
            ['name' => 'コーヒーミル', 'price' => 4000, 'description' => '手動のコーヒーミル', 'condition' => '良好', 'image' => 'products/Waitress+with+Coffee+Grinder.jpg'],
            ['name' => 'メイクセット', 'price' => 2500, 'description' => '便利なメイクアップセット', 'condition' => '目立った傷や汚れなし', 'image' => 'products/外出メイクアップセット.jpg'],
        ];

        // 商品をデータベースに登録
        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'description' => $product['description'],
                'price' => $product['price'],
                'condition' => $product['condition'],
                'image' => $product['image'],
                'user_id' => $user->id,
                'is_sold' => false,
            ]);
        }
    }
}
