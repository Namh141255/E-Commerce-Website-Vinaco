<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function listing(Request $request){
        $url = Route::getFacadeRoot()->current()->uri;
        $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount> 0){
            //Get Category Details
            $categoryDetails = Category::categoryDetails($url);
            // dd($categoryDetails);

            //Get Category and their Sub Category Product
            $categoryProducts = Product::with(['images'])->whereIn('category_id',$categoryDetails['catIds'])->where('products.status',1);
            // dd($categoryProducts);

            //Update Query for Products Sorting
            if(isset($request['sort'])&& !empty($request['sort'])){
                if($request['sort']=="product_lastest"){
                    $categoryProducts->orderBy('id','desc');
                }else if($request['sort']=="lowest_price"){
                    $categoryProducts->orderBy('final_price','ASC');
                }else if($request['sort']=="highest_price"){
                    $categoryProducts->orderBy('final_price','DESC');
                }else if($request['sort']=="best_selling"){
                    $categoryProducts->where('is_bestseller','Yes');
                }else if($request['sort']=="featured_items"){
                    $categoryProducts->where('is_featured','Yes');
                }else if($request['sort']=="discounted_items"){
                    $categoryProducts->where('product_discount','>',0);
                }else{
                    $categoryProducts->orderBy('products.id','desc');
                }
            }

            //Update Query for Colors Filter
            if(isset($request['color'])&& !empty($request['color'])){
                $colors = explode('~',$request['color']);
                $categoryProducts->whereIn('products.family_color',$colors);
            }

            //Update Query for Style Filter
            if(isset($request['style'])&& !empty($request['style'])){
                $styles = explode('~',$request['style']);
                $categoryProducts->join('products_attributes','products_attributes.product_id','=','products.id')->whereIn('products_attributes.style',$styles)
                -> groupBy('products_attributes.product_id');
            }

            //Update Query for Price Filter
            if(isset($request['price'])&& !empty($request['price'])){
                $request['price'] = str_replace("~","-",$request['price']);
                $prices = explode('-',$request['price']);
                $count = count($prices);
                $categoryProducts->whereBetween('products.final_price',[$prices[0], $prices[$count-1]]);
            }

             //Update Query for Dynamic Filter
             $filterTypes = ProductsFilter::filterTypes();
             foreach ($filterTypes as $key => $filter) {
                if($request -> $filter){
                    $explodeFilterVals = explode('~',$request -> $filter);
                    $categoryProducts->whereIn($filter,$explodeFilterVals);
                }
             }

            $categoryProducts = $categoryProducts->paginate(3); // Should multiples of 3

            if($request ->ajax()){
                return response()->json([
                    'view'=>(String)View::make('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'))
                ]);
            }else{
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }
           
        }else{
            abort(404);
        }
    }

    public function detail($id){
        $productCount = Product::where('status',1)->where('id',$id)->count();
        if($productCount==0){
            abort(404);
        }
        $productDetails = Product::with(['category','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images'])->find($id)->toArray();
        // dd($productDetails);

        //Get Category Details
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);

        //Get Group Product (Product Colors)
        $groupProducts = array();
        if(!empty($productDetails['group_code'])){
            $groupProducts = Product::select('id','product_color')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'], 'status'=> 1])->get()->toArray();
            // dd($groupProducts);
        }

        $relatedProducts = Product::with('images')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        // dd($productDetails);
        
        //Set Session For Recently Viewed Items\
        if(empty(Session::get('session_id'))){
            $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }
        Session::put('session_id',$session_id);

        //Insert product in recently_viewed_items_table if not already exists
        $countRecentlyViewedItems = DB::table('recently_viewed_items')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedItems == 0){
            DB::table('recently_viewed_items')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        //Get Recently Viewed Products Ids
        $recentlyProductIds = DB::table('recently_viewed_items')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        // dd($recentlyProductIds);

        //Get Recently Viewed Products
        $recentlyViewedProducts = Product::with('images')->whereIn('id',$recentlyProductIds)->get()->toArray();

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','groupProducts','relatedProducts','recentlyViewedProducts'));
    }

    public function getAttributePrice(Request $request){
        if($request->ajax()){
            $data = $request -> all();
            // echo "<pre>";print_r($data); die;
            $getAttributePrice = Product::getAttributePrice($data['product_id'],$data['style']);
            // echo "<pre>";print_r($getAttributePrice); die;
            return $getAttributePrice;
        }
    }

    public function addToCart(Request $request){
        if($request->isMethod('post')){   
            $data = $request ->all();
            // echo "<pre>";print_r($data); die;

            // Check Product Stock
            $productStock = ProductsAttribute::productStock($data['product_id'],$data['style']);
            if($data['qty'] > $productStock){
                $message = "Required Quantity is not available!";
                return response()->json(['status'=>false,'message'=>$message]);
            }

            // Check Product Status
            $productStatus = Product::productStatus($data['product_id']);
            if($productStatus == 0){
                $message = "Product is not available!";
                return response()->json(['status'=>false,'message'=>$message]);
            }

            //Genarate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }else{
                $session_id = Session::get('session_id');
            }
            // echo $session_id; die;

            //Check Prioduct Already exists in the User Cart
            if(Auth::check()){
                //User is logged in
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=> $data['product_id'],'product_style'=>$data['style'],'user_id'=>$user_id])->count();
            }else{
                //User is not logged in
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=> $data['product_id'],'product_style'=>$data['style'],'session_id'=>$session_id])->count();

            }

            if($countProducts > 0){
                $message = "Product already exists in Cart!";
                return response()->json(["status"=>false,"message"=>$message]);
            }

            //Save the Product in carts table
            $item = new Cart;
            $item -> session_id = $session_id;
            if(Auth::check()){
                $item->user_id = Auth::user()->id;
            }
            $item->product_id = $data["product_id"];
            $item->product_qty = $data["qty"];
            $item->product_style = $data["style"];
            $item->Save();
            $message = "Product added successfully in Cart!";
            return response()->json(["status"=>true,"message"=>$message]);  
        }
    }
}
