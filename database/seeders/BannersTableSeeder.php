<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerRecords = [
            ['id'=>1,'type'=>'Slider','banner_image'=>'slide-banner-1.png','link'=>'','title'=>'Spring Collection','alt'=>'Spring Collection','sort'=> 1,'status'=> 1],
            ['id'=>2,'type'=>'Slider','banner_image'=>'slide-banner-2.png','link'=>'','title'=>'Summer Collection','alt'=>'Summer Collection','sort'=> 2,'status'=> 1]
        ];
        Banner::insert($bannerRecords); 
    }
}
