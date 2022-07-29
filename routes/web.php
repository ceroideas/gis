<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ElementsController;

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
    return view('admin.login');
});

Route::get('test', [ElementsController::class, 'test']);
Route::get('/admin/home', [ElementsController::class, 'home']);
Route::get('/admin/load-red-data-to-map/{id}', [ElementsController::class, 'loadRedData']);


Route::post('/admin-login' , [ElementsController::class, 'loginAdmin']);
Route::post('/uploadOverlay' , [ElementsController::class, 'uploadOverlay']);
Route::post('/admin/save-new-element' , [ElementsController::class, 'saveNewElement']);

