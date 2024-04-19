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
}
