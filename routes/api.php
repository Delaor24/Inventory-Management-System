<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api', 'prefix' => 'auth'],function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'api','namespace'=>'Api'],function ($router) {
    Route::apiResource('employees','EmployeeController');
    Route::apiResource('suppliers','SupplierController');
    Route::apiResource('categories','CategoryController');
    Route::apiResource('products','ProductController');
    Route::get('all-product','ProductController@allProducts');
    Route::apiResource('expenses','ExpenseController');
    Route::post('salary-pay/{id}','SalaryController@salaryPay');
    Route::get('salaries/{month}','SalaryController@index');
    Route::get('salary/months','SalaryController@salaryMonthList');
    Route::get('salary/edit/{id}','SalaryController@salaryEdit');
    Route::patch('salary/update/{id}','SalaryController@salaryUpdate');
    Route::get('all-salary','SalaryController@allSalary');
    Route::delete('salary/delete/{id}','SalaryController@salaryDelete');
    Route::apiResource('customers','CustomerController');
    //post controller
    Route::get('product/category/{id}','PosController@categoryProducts');
    // cart route
    Route::get('add-to-cart/product/{id}','CartController@addToCart');
    Route::get('product/carts','CartController@getCarts');
    Route::get('/cart-remove/{id}','CartController@cartRemove');
    Route::get('/cart-increment/{id}','CartController@cartIncrement');
    Route::get('/cart-decrement/{id}','CartController@cartDecrement');
    Route::get('/cart-quantity/','CartController@cartQuantity');
    Route::get('/cart-subtotal/','CartController@cartSubtotal');
    Route::get('/carts-product-price-total/','CartController@cartsProductPrice');
    Route::post('/order-done/','PosController@orderStore');
    //order route
    Route::get('today-orders','OrderController@todayOrder');
    Route::get('order-info/{id}','OrderController@orderInfo');
    Route::get('order-details/{id}','OrderController@orderDetails');
    Route::get('orders','OrderController@orders');
    Route::delete('order-delete/{id}','OrderController@orderDelete');
    Route::post('order-search-date','OrderController@orderDate');
    Route::post('order-search-month','OrderController@orderMonth');
    //home page
    Route::get('today-income','OrderController@todayIncome');
    Route::get('today-sell','OrderController@todaySell');
    Route::get('today-due','OrderController@todayDue');
    Route::get('today-expense','OrderController@todayExpense');
});


