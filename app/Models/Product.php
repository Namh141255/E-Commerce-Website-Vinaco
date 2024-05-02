<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id')->with('parentcategory');
    }

    public static function productsFilters(){
        //Product Filters
        $productsFilters['materialArray'] = array('Wood','Metal','Mica');
        $productsFilters['sizeArray'] = array('4 inch','5 inch','6 inch','10 inch','15 inch','22 inch','25 inch','30 inch','40 inch');
        $productsFilters['layersArray'] = array('1 layers','2 layers','3 layers');
        $productsFilters['shapeArray'] = array('Decor','Heart','Oval','Square','Circle');
        $productsFilters['piecesArray'] = array('1 pcs','50 pcs','100 pcs','300 pcs','1000 pcs');
        return $productsFilters;
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public static function getAttributePrice($product_id,$style){
        $attributePrice = ProductsAttribute::where(['product_id'=>$product_id,'style'=>$style])->first()->toArray();

        //For Getting Product Discount
        $productDetails = Product::select(['product_discount','category_id'])->where('id',$product_id)->first()->toArray();
        //For Getting Category Discount
        $categoryDetails = Category::select(['category_discount'])->where('id',$productDetails['category_id'])->first()->toArray();

        if($productDetails['product_discount']>0){
            // 1st case if there is any Product Discount
            $discount = $attributePrice['price']*$productDetails['product_discount']/100;
            $discount_percent = $productDetails['product_discount'];
            $final_price = $attributePrice['price']-$discount;
        }else if($categoryDetails['category_discount']>0){
            // 2nd case if there is any Category Discount
            $discount = $categoryDetails['price']*$productDetails['category_discount']/100;
            $discount_percent = $productDetails['category_discount'];
            $final_price = $attributePrice['price']-$discount;
        }else{
            //If there is no discount
            $discount = 0;
            $discount_percent = 0;
            $final_price = $attributePrice['price'];
        }
        return array('product_price'=>$attributePrice['price'],'final_price'=>$final_price,'discount'=>$discount,'discount_percent'=> $discount_percent);
    }

}
