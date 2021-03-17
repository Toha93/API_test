<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController as Auth;
use App\Http\Controllers\CatalogController as Catalog;
use App\Http\Controllers\CartController as Cart;
use App\Http\Controllers\OrderController as Order;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login',[Auth::class, 'Login']);
Route::post('/register', [Auth::class, 'Register']);

Route::post('/categories',[Catalog::class, 'categories']);
Route::post('/products',[Catalog::class, 'getProducts']);
Route::post('/product',[Catalog::class, 'getProduct']);

Route::post('/useraddcart',[Cart::class, 'AddToCart']);
Route::post('/usercart',[Cart::class, 'getUserCart']);
Route::post('/useraddorder',[Order::class, 'addOrder']);
Route::post('/userorders',[Order::class, 'getOrders']);
Route::post('/removecart',[Cart::class, 'RemoveAllCartItems']);
Route::post('/char',[Catalog::class, 'addCharacteristics']);
