<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;

class ProductController extends Controller
{
    public function listing(){
        $url = Route::getFacadeRoot()->current()->uri;
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount> 0){
            //Get Category Details
            $categoryDetails = Category::categoryDetails($url);
            dd($categoryDetails);
        }else{
            abort(404);
        }
    }
}
