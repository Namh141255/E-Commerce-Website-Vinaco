<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

class IndexController extends Controller
{
    public function index(){

        //Get home page Slider Banner
        $homeSliderBanners = Banner::where('type','Slider')->where('status',1)->orderBy('sort','ASC')->get()->toArray();
        $homeFixBanners = Banner::where('type','Fix')->where('status',1)->orderBy('sort','ASC')->get()->toArray();
        return view('front.index')->with(compact('homeSliderBanners','homeFixBanners'));
    }
}
