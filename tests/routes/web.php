<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Middleware\Test;
use App\Models\Orders;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(OrdersController::class)->group(function(){
    Route::get('/orders', 'index');
    Route::post('/orders/submit', 'submit_form')->name('orders.submit');
});

Route::get('/home', [HomeController::class, 'show']);

Route::get('/', function () {
    return view('welcome');
});
