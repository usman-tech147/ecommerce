<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\MusicController;
use Illuminate\Support\Facades\Route;
use App\PhpClasses\Person;

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

Route::get('/', [MusicController::class, 'queries']);

Route::get('/', function () {
    return view('index');
})->name('user_products');


Route::get('/products', [ProductController::class, 'index'])->name('index');
Route::post('/get-all-products',[ProductController::class, 'getAllProducts'])->name('get-all-products');

Route::get('/get-subcategories', [ProductController::class, 'getSubcategories'])->name('subcategories');

Route::get('/product/create', [ProductController::class, 'create'])->name('create');
Route::post('/product/store', [ProductController::class, 'store'])->name('store');
Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('edit');
Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
Route::post('/product/delete',[ProductController::class, 'delete'])->name('product.delete');
Route::get('/product/show', [ProductController::class, 'show'])->name('show');

Route::get('/customer',[\App\Http\Controllers\CustomerProductController::class, 'index'])->name('customer');
Route::post('/customer/filter-product',[\App\Http\Controllers\CustomerProductController::class, 'filterProduct'])->name('filter.product');