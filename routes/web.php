<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
   if (!auth()->check()) {
       return redirect()->route('login.get');
   }

   return redirect()->route('dashboard');
})->name('home');

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login.get');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('login.post');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register.get');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

    Route::prefix('products')->group(function () {
        Route::resource('', \App\Http\Controllers\Products\ProductController::class)->names('products')->parameters(['' => 'id']);
        Route::post('/brands', [\App\Http\Controllers\Products\BrandController::class, 'save'])->name('products.brands.save');
        Route::delete('/brands/{id}', [\App\Http\Controllers\Products\BrandController::class, 'delete'])->name('products.brands.delete');
        Route::post('/categories', [\App\Http\Controllers\Products\CategoryController::class, 'save'])->name('products.categories.save');
        Route::delete('/categories/{id}', [\App\Http\Controllers\Products\CategoryController::class, 'delete'])->name('products.categories.delete');
        Route::post('/colors', [\App\Http\Controllers\Products\ColorController::class, 'save'])->name('products.colors.save');
        Route::delete('/colors/{id}', [\App\Http\Controllers\Products\ColorController::class, 'delete'])->name('products.colors.delete');
        Route::post('/sizes', [\App\Http\Controllers\Products\SizeController::class, 'save'])->name('products.sizes.save');
        Route::delete('/sizes/{id}', [\App\Http\Controllers\Products\SizeController::class, 'delete'])->name('products.sizes.delete');
    });

    Route::resource('clients', \App\Http\Controllers\ClientController::class)->names('clients');

    Route::prefix('suppliers')
        ->group(function () {
            Route::resource('', \App\Http\Controllers\Suppliers\SupplierController::class)->names('suppliers')->parameters(['' => 'id']);
            Route::resource('/{supplier_id}/orders', \App\Http\Controllers\Suppliers\SupplierOrderController::class)->names('suppliers.orders');
            Route::post('/{supplier_id}/orders/items', [\App\Http\Controllers\Suppliers\SupplierOrderItemController::class, 'create'])->name('suppliers.orders.items.create');
            Route::delete('/{supplier_id}/orders/{supplier_order_id}/items/{supplier_order_item_id}', [\App\Http\Controllers\Suppliers\SupplierOrderItemController::class, 'destroy'])->name('suppliers.orders.items.destroy');
        });

    Route::prefix('sales')->group(function () {
        Route::resource('', \App\Http\Controllers\Sales\SaleController::class)->names('sales')->parameters(['' => 'id'])->except(['show']);
        Route::get('/getClientOptions', [\App\Http\Controllers\Sales\SaleController::class, 'getClientOptions'])->name('sales.getClientOptions');
        Route::get('/getPaymentMethodOptions', [\App\Http\Controllers\Sales\SaleController::class, 'getPaymentMethodOptions'])->name('sales.getPaymentMethodOptions');
        Route::get('/getProductsOptions', [\App\Http\Controllers\Sales\SaleController::class, 'getProductsOptions'])->name('sales.getProductsOptions');
        Route::post('/{sale_id}/items', [\App\Http\Controllers\Sales\SaleItemController::class, 'create'])->name('sales.items.create');
        Route::delete('/{sale_id}/items/{sale_item_id}', [\App\Http\Controllers\Sales\SaleItemController::class, 'destroy'])->name('sales.items.destroy');
        Route::resource('/{sale_id}/installments', \App\Http\Controllers\Sales\SaleInstallmentController::class)->names('sales.installments');
    });
});

