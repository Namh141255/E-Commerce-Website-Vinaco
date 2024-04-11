<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $categoryRecords = [
            ['id' => 1,'parent_id'=> 0,'category_name'=>'Home-Decor', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'home-decor',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 2,'parent_id'=> 0,'category_name'=>'Puzzle', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'puzzle',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 3,'parent_id'=> 0,'category_name'=>'Wall-Art', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'wall-art',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 4,'parent_id'=> 1,'category_name'=>'Night-Lamp', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'night-lamp',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 5,'parent_id'=> 1,'category_name'=>'Suncatcher', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'suncatcher',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 6,'parent_id'=> 2,'category_name'=>'Personalize', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'personalize',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 7,'parent_id'=> 2,'category_name'=>'Animal', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'animal',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 8,'parent_id'=> 3,'category_name'=>'Metal-Sign', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'metal-sign',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 9,'parent_id'=> 3,'category_name'=>'Canvas', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'canvas',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
            ['id' => 10,'parent_id'=> 3,'category_name'=>'Wooden-Sign', 'category_image'=>'', 'category_discount'=>0, 'description'=>'','url'=>'Wooden-sign',
            'meta_title'=>'', 'meta_description'=>'','meta_keywords'=>'','status'=>1],
        ];

        Category::insert($categoryRecords);
    }
}
