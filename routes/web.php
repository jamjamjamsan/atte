<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkTimeController;


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

Route::get('/',[WorkTimeController::class, "index"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware("authi")->group(function(){
    Route::post("/reststart",[RestController::class,"restStart"]);

    Route::post("/restend", [RestController::class, "restEnd"]);

    Route::post("/workstart", [WorkTimeController::class, "workStart"]);

    Route::post("/workend", [WorkTimeController::class, "workEnd"]);

    Route::get("/attendance",[WorkTimeController::class,"show"]);

});