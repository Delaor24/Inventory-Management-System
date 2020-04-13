<?php

namespace App\Http\Controllers\Api;

use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart($id){
        $product = Product::findOrfail($id);
        $sameProductCheck = DB::table('carts')->where('product_id',$id)->first();
        if($sameProductCheck){
            if($sameProductCheck->product_quantity < $product->p_quantity){
                DB::table('carts')->where('product_id',$id)->increment('product_quantity');
                $cart= DB::table('carts')->where('product_id',$id)->first();
                DB::table('carts')->where('product_id',$id)->update(['sub_total'=>$cart->product_quantity * $cart->product_price]);
            }else{
                return response()->json(['error'=>'Can not increment. out of stack']);
            }

        }else{
            $data = [];
            $data['product_id']=$id;
            $data['product_name']=$product->p_name;
            $data['product_quantity']=1;
            $data['product_price']=$product->selling_price;
            $data['sub_total']=$product->selling_price;
            DB::table('carts')->insert($data);
            return response()->json(['success'=>'Cart added']);
        }

    }
    public function getCarts(){
        $carts = DB::table('carts')->get();
        return response()->json($carts);
    }
    public function cartRemove($id){
        $cart = DB::table('carts')->delete($id);
        return response()->json(['success'=>'Cart deleted']);
    }
    public function cartIncrement($id){
         $newCart = DB::table('carts')->find($id);
         $product_id = $newCart->product_id;
         $product = Product::find($product_id);
         $product_quantity = $product->p_quantity;
         if($newCart->product_quantity < $product_quantity){
             DB::table('carts')->where('id',$id)->increment('product_quantity');
             $cart = DB::table('carts')->where('id',$id)->first();
             DB::table('carts')->where('id',$id)->update(['sub_total'=>$cart->product_quantity * $cart->product_price]);
             return response()->json($id);
         }else{
             return response()->json(['error'=>'Can not increment. out of stack']);
         }
    }
    public function cartDecrement($id){
        DB::table('carts')->where('id',$id)->decrement('product_quantity');
        $cart = DB::table('carts')->where('id',$id)->first();
        DB::table('carts')->where('id',$id)->update(['sub_total'=>$cart->product_quantity * $cart->product_price]);
        return response()->json($id);
    }
    public function cartQuantity(){
        $cartQuantity = DB::table('carts')->sum('product_quantity');
        return response()->json($cartQuantity);
    }

    public function cartSubtotal(){
        $subtotal = DB::table('carts')->sum('sub_total');
        return response()->json($subtotal);
    }
    public function cartsProductPrice(){
        $subTotal = DB::table('carts')->sum('sub_total');
        $totalPrice=round(($subTotal * 5/100)+$subTotal);
        return response()->json($totalPrice);
    }
}
