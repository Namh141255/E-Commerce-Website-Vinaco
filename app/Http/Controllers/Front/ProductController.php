<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function listing(){
        $url = Route::getFacadeRoot()->current()->uri;
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount> 0){
            //Get Category Details
            $categoryDetails = Category::categoryDetails($url);
            // dd($categoryDetails);

            //Get Category and their Sub Category Product
        $categoryProducts = Product::with(['images'])->whereIn('category_id',$categoryDetails['catIds'])->where('status',1) -> orderBy('id','Desc')->paginate(1);
            // dd($categoryProducts);

            return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
        }else{
            abort(404);
        }
    }
}
