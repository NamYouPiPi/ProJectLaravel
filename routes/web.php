<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorController;
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
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
    return view('Dashboard.index');
});
// Route::get('/suppliers', function () {
//     return redirect('suppliers');
// });


Route::resource('/suppliers', SupplierController::class);

//Route::get('/category' , [CategoryController::class , 'index'])->name('category.index');
