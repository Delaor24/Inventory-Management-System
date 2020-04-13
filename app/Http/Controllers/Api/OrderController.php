<?php

namespace App\Http\Controllers\Api;

use App\Model\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function todayOrder(){
        $orders = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_date',date('d/m/Y'))->orderBy('orders.id','DESC')->get();
        return response()->json($orders);
    }
    public function orderInfo($id){
        $orders = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->where('orders.id',$id)->first();
        return response()->json($orders);
    }
    public function orderDetails($id){
        $orderDetails= DB::table('order_details')
            ->join('products','order_details.product_id','products.id')
            ->where('order_details.order_id',$id)->get();
        return response()->json($orderDetails);
    }
    public function orders(){
        $orders = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->orderBy('orders.id','DESC')
            ->get();
        return response()->json($orders);
    }
    public function orderDelete($id){
        $details = DB::table('order_details')->where('order_id',$id)->get();
        foreach ($details as $detail){
            DB::table('order_details')->delete($detail->id);
        }
        DB::table('orders')->delete($id);
        return response()->json(['success'=>'Orders & Order Details Data Deleted!']);
    }
    public function orderDate(Request $request){
        $this->validate($request,['date'=>'required']);
        $date = Carbon::parse($request->date)->format('d/m/Y');

        $orders = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_date',$date)->get();
        return response()->json($orders);
    }

    public function orderMonth(Request $request){
        $this->validate($request,['month'=>'required']);
        $month = $request->month;
        $orders = DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_month',$month)->get();
        return response()->json($orders);
    }
    public function todayIncome(){
        $todayIncome = DB::table('orders')->where('order_date',date('d/m/Y'))->sum('total');
        return response()->json($todayIncome);
    }
    public function todaySell(){
        $todaySell = DB::table('orders')->where('order_date',date('d/m/Y'))->sum('pay');
        return response()->json($todaySell);
    }

    public function todayDue(){
        $todayDue= DB::table('orders')->where('order_date',date('d/m/Y'))->sum('due');
        return response()->json($todayDue);
    }

    public function todayExpense(){
        $date = date('Y-m-d');
        $todayExpense = Expense::where('created_at','LIKE',"%$date%")->sum('amount');
        return response()->json($todayExpense);
    }
}
