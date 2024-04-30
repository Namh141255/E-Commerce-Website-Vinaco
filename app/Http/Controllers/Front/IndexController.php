<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){

        //Get home page Slider Banners
        $homeSliderBanners = Banner::where('type','Slider')->where('status',1)->orderBy('sort','ASC')->get()->toArray();
        //Get home page fix banners
        $homeFixBanners = Banner::where('type','Fix')->where('status',1)->orderBy('sort','ASC')->get()->toArray();

        //Get New Products
        $newProducts = Product::with(['images'])->where('status',1) -> orderBy('id','Desc')->limit(4)->get()->toArray();
        // dd($newProducts);

        //Get Best Seller Products
        $bestSellers = Product::with(['images'])->where(['is_bestseller' => 'Yes','status' =>1]) ->inRandomOrder()->limit(4)->get()->toArray();

        //Get Discounted Products
        $discountedProducts = Product::with(['images'])->where('product_discount','>', 0)->where('status',1)->inRandomOrder()->limit(4)->get()->toArray();

        //Get featured Products
        $featuredProducts = Product::with(['images'])->where(['is_featured' => 'Yes','status' =>1]) ->inRandomOrder()->limit(4)->get()->toArray();

        //Get New Arrival Products
        $newArrivalProducts = Product::with(['images'])->where('status',1) -> orderBy('id','Desc')->get()->toArray();

        //View more featured Products
        $moreFeaturedProducts = Product::with(['images'])->where(['is_featured' => 'Yes','status' =>1]) ->inRandomOrder()->get()->toArray();

        return view('front.index')->with(compact('homeSliderBanners','homeFixBanners','newProducts','bestSellers','discountedProducts','featuredProducts',
        'newArrivalProducts','moreFeaturedProducts'));
    }
}
