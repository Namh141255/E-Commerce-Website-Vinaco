<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productsRecords = [
            ['id'=>1,'category_id'=>4,'brand_id'=>0,'product_name'=>'Heart Shape NL','product_code'=>'NL0001','product_color'=>'Lotus Pink','family_color'=>'Pink',
            'group_code'=>'NLDECOR0000','product_price'=>150,'product_discount'=>'10','discount_type'=>'product','final_price'=>135,'product_weight'=>500,'product_video'=>'',
            'description'=>'Heart shape Night lamp decor', 'search_keywords'=>'','material'=>'','size'=>'','layers'=>'','shape'=>'','pieces'=>'','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1],
            ['id'=>2,'category_id'=>13,'brand_id'=>0,'product_name'=>'Two cat in tree','product_code'=>'TC0001','product_color'=>'Natural Wood','family_color'=>'Wood',
            'group_code'=>'WSuncatcher0000','product_price'=>250,'product_discount'=>'0','discount_type'=>'','final_price'=>250,'product_weight'=>600,'product_video'=>'',
            'description'=>'Two cat in tree wooden suncatcher', 'search_keywords'=>'','material'=>'','size'=>'','layers'=>'','v'=>'','pieces'=>'','meta_title'=>'',
            'meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],
        ];
        Product::insert($productsRecords);
    }
}
