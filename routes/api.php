<?php

// use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/discount/order', 			'OrderController@store');
Route::post('/discount/discount', 		'DiscountController@store');
Route::post('/discount/customer', 		'CustomerController@store');
Route::post('/discount/customers',		'CustomerController@storeMultiple');
Route::post('/discount/product', 		'ProductController@store');
Route::post('/discount/products', 		'ProductController@storeMultiple');
Route::post('/discount/category', 		'CategoryController@store');
Route::post('/discount/categories',		'CategoryController@storeMultiple');

Route::post('/discount/order', 			'OrderController@store');

Route::get('/test',function(){
     return "ok";
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
