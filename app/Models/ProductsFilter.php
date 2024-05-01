<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

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

    public static function getDynamicFilters($catIds){
        $getProductIds = Product::select('id')->whereIn('category_id',$catIds)->pluck('id');
        $getFilterColumns = ProductsFilter::select('filters_name')->pluck('filters_name')->toArray();
       
        if(count($getFilterColumns) > 0){
            $getFilterValues = Product::select($getFilterColumns)->whereIn('id',$getProductIds)->where('status',1)->get()->toArray();
        }else{
            $getFilterValues = Product::whereIn('id',$getProductIds)->where('status',1)->get()->toArray();
        }
        $getFilterValues = array_filter(array_unique(Arr::flatten($getFilterValues)));
        // dd($getFilterValues);

        $getCategoryFilterColumns = ProductsFilter::select('filters_name')->whereIn('filters_value',$getFilterValues)
        ->groupBy('filters_name')->orderBy('sort','ASC')->where('status',1)->pluck('filters_name')->toArray();
        // dd($getCategoryFilterColumns);
        return $getCategoryFilterColumns;
    }

    public static function selectedfilters($filters_name,$catIds){
        $productFilters = Product::select($filters_name)->whereIn('category_id',$catIds)->groupBy($filters_name)->get()->toArray();
        $productFilters = array_filter(Arr::flatten($productFilters));
        return $productFilters;
    }

    public static function filterTypes(){
        $filterTypes = ProductsFilter::select('filters_name')->groupBy('filters_name')->where('status',1)->get()->toArray();
        $filterTypes = Arr::flatten($filterTypes);
        return $filterTypes;
    }

}
