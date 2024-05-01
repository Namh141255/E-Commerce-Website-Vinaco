<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsFilter;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filterRecords = [
            ['id'=>1,'filters_name'=> 'Material','filters_value'=> 'Wood','sort'=> 1,'status'=> 1],
            ['id'=>2,'filters_name'=> 'Material','filters_value'=> 'Metal','sort'=> 2,'status'=> 1],
            ['id'=>3,'filters_name'=> 'Material','filters_value'=> 'Mica','sort'=> 3,'status'=> 1],
            ['id'=>4,'filters_name'=> 'Size','filters_value'=> '4 inch','sort'=> 1,'status'=> 1],
            ['id'=>5,'filters_name'=> 'Size','filters_value'=> '5 inch','sort'=> 2,'status'=> 1],
            ['id'=>6,'filters_name'=> 'Size','filters_value'=> '6 inch','sort'=> 3,'status'=> 1],
            ['id'=>7,'filters_name'=> 'Size','filters_value'=> '10 inch','sort'=> 4,'status'=> 1],
            ['id'=>8,'filters_name'=> 'Size','filters_value'=> '15 inch','sort'=> 5,'status'=> 1],
            ['id'=>9,'filters_name'=> 'Size','filters_value'=> '22 inch','sort'=> 6,'status'=> 1],
            ['id'=>10,'filters_name'=> 'Size','filters_value'=> '25 inch','sort'=> 7,'status'=> 1],
            ['id'=>11,'filters_name'=> 'Size','filters_value'=> '30 inch','sort'=> 8,'status'=> 1],
            ['id'=>12,'filters_name'=> 'Size','filters_value'=> '40 inch','sort'=> 9,'status'=> 1],
            ['id'=>13,'filters_name'=> 'Layers','filters_value'=> '1 layers','sort'=> 1,'status'=> 1],
            ['id'=>14,'filters_name'=> 'Layers','filters_value'=> '2 layers','sort'=> 2,'status'=> 1],
            ['id'=>15,'filters_name'=> 'Layers','filters_value'=> '3 layers','sort'=> 3,'status'=> 1],
            ['id'=>16,'filters_name'=> 'Shape','filters_value'=> 'Decor','sort'=> 1,'status'=> 1],
            ['id'=>17,'filters_name'=> 'Shape','filters_value'=> 'Heart','sort'=> 2,'status'=> 1],
            ['id'=>18,'filters_name'=> 'Shape','filters_value'=> 'Oval','sort'=> 3,'status'=> 1],
            ['id'=>19,'filters_name'=> 'Shape','filters_value'=> 'Square','sort'=> 4,'status'=> 1],
            ['id'=>20,'filters_name'=> 'Shape','filters_value'=> 'Circle','sort'=> 5,'status'=> 1],
            ['id'=>21,'filters_name'=> 'Pieces','filters_value'=> '1 pcs','sort'=> 1,'status'=> 1],
            ['id'=>22,'filters_name'=> 'Pieces','filters_value'=> '50 pcs','sort'=> 2,'status'=> 1],
            ['id'=>23,'filters_name'=> 'Pieces','filters_value'=> '100 pcs','sort'=> 3,'status'=> 1],
            ['id'=>24,'filters_name'=> 'Pieces','filters_value'=> '300 pcs','sort'=> 4,'status'=> 1],
            ['id'=>25,'filters_name'=> 'Pieces','filters_value'=> '1000 pcs','sort'=> 5,'status'=> 1],

        ];
        ProductsFilter::insert($filterRecords);
    }
}
