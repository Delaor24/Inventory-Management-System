<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Supplier;
use App\Model\Category;
class Product extends Model
{
    protected $fillable = ['p_name','p_code','category_id','supplier_id','root','buying_price','selling_price','buying_date','p_quantity','image'];
    public function category(){
    	return $this->belongsTo(Category::class);
    }
     public function supplier(){
    	return $this->belongsTo(Supplier::class);
    }
}
