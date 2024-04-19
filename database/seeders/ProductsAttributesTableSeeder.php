<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ProductsAttributeRecords = [
            ['id'=>1, 'product_id'=>1, 'style'=>'Filmy', 'sku'=> 'NL0001F', 'price'=> 1000, 'stock'=>100, 'status'=> 1],
            ['id'=>2, 'product_id'=>1, 'style'=>'Dark', 'sku'=> 'NL0001D', 'price'=> 800, 'stock'=>100, 'status'=> 1],
            ['id'=>3, 'product_id'=>1, 'style'=>'Crystal', 'sku'=> 'NL0001C', 'price'=> 1500, 'stock'=>100, 'status'=> 1],
        ];
        ProductsAttribute::insert($ProductsAttributeRecords);
    }
}
