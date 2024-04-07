<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make("123456");
        $adminRecords = [
            ['id'=> 2,'name'=> 'Dino', 'type'=> 'subadmin', 'mobile'=> '0123456789','email'=> 'dino@admin.com','password'=> $password,
        'image'=>'','status'=>1],
        ['id'=> 3,'name'=> 'Queen', 'type'=> 'subadmin', 'mobile'=> '0988888888','email'=> 'queen@admin.com','password'=> $password,
        'image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);
    }
}
