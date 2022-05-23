<?php

use App\Http\Controllers\CiclesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ModulsController;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

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
    return view('plantilla.index');
});

Route::resource('cicles', CiclesController::class);
Route::resource('cursos', CursosController::class);
Route::resource('moduls', ModulsController::class);
