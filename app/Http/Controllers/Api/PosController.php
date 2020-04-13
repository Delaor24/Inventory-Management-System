<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use App\Model\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function categoryProducts($id){
        $category = Category::findOrfail($id);
        $products = $category->products;
        return response()->json($products);
    }
    public function orderStore(Request $request){
        $this->validate($request,[
            'customer_id'=>'required',
            'payby'=>'required',
        ]);

        $data=[];
        $data['customer_id']=$request->customer_id;
        $data['cart_quantity']=$request->cart_quantity;
        $data['sub_total']=$request->sub_total;
        $data['total']=$request->total;
        $data['vat']=$request->vat;
        $data['pay']=$request->pay;
        $data['due']=$request->due;
        $data['payby']=$request->payby;
        $data['order_date']=date('d/m/Y');
        $data['order_month']=date('F');
        $data['order_year']=date('Y');
       $order_id = DB::table('orders')->insertGetId($data);
       $carts = DB::table('carts')->get();
       foreach ($carts as $cart){
           $orderData=[];
           $orderData['order_id']=$order_id;
           $orderData['product_id']=$cart->product_id;
           $orderData['product_quantity']=$cart->product_quantity;
           $orderData['sub_total']=$cart->sub_total;
           $orderData['product_price']=$cart->product_price;
           DB::table('order_details')->insert($orderData);
           DB::table('products')->where('id',$cart->product_id)->update(['p_quantity'=>DB::raw('p_quantity -'.$cart->product_quantity)]);
       }
       DB::table('carts')->delete();
        return response()->json(['success'=>'Successfully Order Complete!']);
    }
}
