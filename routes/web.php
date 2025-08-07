<?php

use App\Http\Controllers\InventoryController;
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CreateModalController;
use App\Http\Controllers\DistributorsController;

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

//add route
Route::get('/', function () {return view('Dashboard.index');});
Route::resource('/suppliers', SupplierController::class);
Route::resource('/inventory',InventoryController::class );
Route::resource('/distributors ', DistributorsController::class);

//Route::get('/modal/createForm',[CreateModalController::class,'getCreateForm'])->name('modal.createForm');

