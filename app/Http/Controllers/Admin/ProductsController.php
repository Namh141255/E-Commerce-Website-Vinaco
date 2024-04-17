<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products(){
        $products = Product::with('category')->get()->toArray();
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where("id", $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=> $status,'product_id'=> $data['product_id']]); 
        }
    }

    public function deleteProduct($id)
    {
        //Delete Product
        Product::where('id', $id)->delete();
        return redirect()->back()->with('success_message','Product deleted successfully');
    }

    public function addEditProduct(Request $request, $id = null){
        Session::put("page","products");
        
        if($id == ""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully!";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product edited successfully!";
        }

        if($request -> isMethod("post")){
            $data = $request -> all();
            // echo "<pre>"; print_r($data); die;
        
            // Product Validations
            // if($id == ""){
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'product_code' => 'required|regex:/^[\w-]*$/|max:255',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'family_color'=> 'required|regex:/^[\pL\s\-]+$/u|max:255',
            ];
            // }else{
            //     $rules = [
            //         'category_name' => 'required',
            //         'url'=> 'required',
            //     ];
            // }

            $customMessages = [
                'category_id.required'=> 'Category is required',
                'product_name.required'=> 'Product Name is required',
                'product_name.regex'=> 'Valid Product Name is required',
                'product_code.required'=> 'Product Code is required',
                'product_code.regex'=> 'Valid Product Code is required',
                'product_price.required'=> 'Product Price is required',
                'product_price.numeric'=> 'Valid Product Price is required',
                'product_color.required'=> 'Product Color is required',
                'product_color.regex'=> 'Valid Product Color is required',
                'family_color.required'=> 'Family Color is required',
                'family_color.regex'=> 'Valid Family Color is required',
            ];
            $this->validate($request,$rules,$customMessages);

            //Upload Product Videos
            if($request->hasFile('product_video')){
                $video_tmp = $request->file("product_video");
                if($video_tmp -> isValid()){

                    //Upload Video
                    $videoExtension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand().'.'.$videoExtension;
                    $videoPath = 'front/videos/products/';
                    $video_tmp -> move($videoPath, $videoName);
                    //Save Video Name in products table
                    $product -> product_video = $videoName;
                };
            }

            if(!isset($data['product_discount'])){
                $data['product_discount'] = 0;
            }

            if(!isset($data['product_weight'])){
                $data['product_weight'] = 0;
            }


            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->family_color = $data['family_color'];
            $product->group_code = $data['group_code'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];

            if(!empty( $data['product_discount']) && $data['product_discount'] > 0){
                $product->discount_type = 'product';
                $product->final_price = $data['product_price'] - ( $data['product_price'] * $data['product_discount']/100);
            }else{
                $getCategoriesDiscount = Category::select('category_discount') -> where('id', $data['category_id'] ) -> first();
                if($getCategoriesDiscount -> category_discount == 0){
                    $product -> discount_type = '';
                    $product -> final_price = $data['product_price'];
                }
            }

            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->search_keywords = $data['search_keywords'];
            $product->material = $data['material'];
            $product->size = $data['size'];
            $product->layers = $data['layers'];
            $product->shape = $data['shape'];
            $product->pieces = $data['pieces'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];
            if(!empty($data['is_featured'])){
                $product -> is_featured = $data['is_featured'];
            }else{
                $product -> is_featured = 'No';
            }
            $product->status = 1;
            $product->save();
            return redirect('admin/products')->with('success_message',$message);

        }

        // get categories and their Sub categories
        $getCategories = Category::getCategories();

        //Product Filters
        $productsFilters = Product::productsFilters();
        return view('admin.products.add_edit_product')->with(compact('title','getCategories','product','productsFilters'));
    }

    public function deleteProductVideo($id){
        //Get Product Video
        $productVideo = Product::select('product_video')->where('id',$id)->first();

        //Get Product Video path
        $product_video_path = 'front/videos/products/';

        //Delete Product Video
        if(file_exists($product_video_path.$productVideo -> product_video)){
            unlink($product_video_path.$productVideo -> product_video);
        }
        Product::where('id',$id)->update(['product_video'=> '']);

        $message = 'Product Video has been deleted';
        return redirect()->back()->with('success_message',$message);
    }
}
