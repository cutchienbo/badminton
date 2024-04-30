<?php

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckIdToken;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\InvalidId;
use Illuminate\Support\Facades\DB;

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

Route::get('/orders', [OrdersController::class, 'index'])->middleware(InvalidId::class);


Route::middleware(CheckIdToken::class)->group(function() {
    Route::controller(OrdersController::class)->group(function () {
        Route::any('/orders/add', 'add');
        Route::any('/orders/delete', 'delete');
        Route::any('/orders/delete_product', 'deleteProduct');
        Route::any('/orders/show_product', 'showOrdersProduct');
        Route::any('/orders/show_menu', 'showMenu');
        Route::any('/orders/add_product', 'addProduct');
        Route::any('/orders/checkout', 'checkout');
        Route::any('/orders/checkout_success', 'checkoutSuccess');
        Route::any('/orders/change_yard/{orders_id}/{yard_id}', 'changeYard');
        Route::any('/orders/pay_more', 'payMore');
        Route::any('/orders/artisan', 'artisan');
    });
    
    Route::controller(ProductController::class)->group(function () {
        Route::any('/product', 'index');
        Route::any('/product/handle_add_product_type', 'handleAddProType');
        Route::any('/product/handle_update_product_type', 'handleUpdateProType');
        Route::any('/product/update_product_type', 'updateProductType');
        Route::any('/product/delete_product_type', 'deleteProductType');
        Route::any('/product/handle_add_product', 'handleAddProduct');
        Route::any('/product/delete_product', 'deleteProduct');
        Route::any('/product/undo_product', 'undoProduct');
        Route::any('/product/update_product', 'updateProduct');
        Route::any('/product/remove_product', 'removeProduct');
        Route::any('/product/handle_update_product', 'handleUpdateProduct');
    });
    
    Route::view('product/add_product', 'layout', [
        'data' => [
            'product_type' => DB::table('type')->get()
        ],
        'content' => 'product/add_product'
    ]);
    
    Route::view('product/add_product_type', 'layout', [
        'data' => [
            'title' => 'THÊM LOẠI SẢN PHẨM',
            'action' => 'handle_add_product_type'
        ],
        'content' => 'product/action_product_type'
    ]);
    
    Route::controller(ManagerController::class)->group(function () {
        Route::any('/manager', 'index')->name('manager_info');
        Route::any('/manager/handle_update_info', 'handleUpdateInfo');
        Route::any('/manager/receive_statistical', 'receiveStatistical');
        Route::any('/manager/summary_price', 'summaryPrice');
    });
});

// Route::get('/orders', [OrdersController::class, 'index']);
