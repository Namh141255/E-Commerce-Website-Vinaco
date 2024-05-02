<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;

    public static function productStock($product_id,$style){
        $productStock = ProductsAttribute::select('stock')->where(['product_id'=>$product_id,'style'=>$style])->first();
        return $productStock->stock;
    }
}
