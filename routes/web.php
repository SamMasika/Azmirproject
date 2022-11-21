<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Stock\StockController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layouts.landing');
});

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::group(['middleware' => 'userAuthe'], function(){
   
    Route::get('dashboard',[AuthController::class,'dashboard']);

    //Items
    Route::get('item-list',[ItemController::class,'index']);
    Route::post('item-store',[ItemController::class,'store']);
    Route::get('item-show',[ItemController::class,'show']);
    Route::post('item-update/{id}',[ItemController::class,'update']);
    Route::get('item-delete',[ItemController::class,'delete']);

    //Stocks
    Route::get('stock-list',[StockController::class,'index']);
    Route::post('stock-store',[StockController::class,'store']);
    Route::get('stock-show',[StockController::class,'show']);
    Route::post('stock-update/{id}',[StockController::class,'update']);
    Route::delete('stock-delete/{id}',[StockController::class,'destroy'])->name('stock.destroy');
    Route::post('stock-control/{id}',[StockController::class,'storeStock']);

});

