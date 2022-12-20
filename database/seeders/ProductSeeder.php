<?php

namespace Database\Seeders;

use App\Models\Product;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create data
        $product = [
            [
                'product_category_id' => '1',
                'name' => 'TV LED 42',
                'price'=> '2500000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id' => '2',
                'name' => 'Kasur',
                'price'=> '600000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'product_category_id' => '2',
                'name' => 'Meja Belajar',
                'price'=> '350000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // data array $product di parsing ke dalam model product untuk di insert ke database
        Product::insert($product);
    }
}
