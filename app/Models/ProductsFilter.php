<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getColors($catIds){
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        // dd($getProductIds);

        $getProductColors = Product::select('family_color')->whereIn('id',$getProductIds)->groupBy('family_color')->pluck('family_color');
        // dd($getProductColors);
        return $getProductColors;
    }

    public static function getStyles($catIds){
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        $getProductStyles = ProductsAttribute::select('style')->where('status',1)->whereIn('id',$getProductIds)->groupBy('style')->pluck('style');
        // dd($getProductStyles);
        return $getProductStyles; 
    }
}
