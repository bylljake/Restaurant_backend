<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Plats\PlatController;
use App\Models\Plat;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('category')->group(function(){
    Route::get('liste',[CategoryController::class,'liste'])->name('liste.category');
    Route::post('create',[CategoryController::class, 'store'])->name('create.category');
    Route::put('edit/{id}',[CategoryController::class,'update'])->name('edit.category');
    Route::delete('delete/{id}',[CategoryController::class,'delete'])->name('delete.category');

});

Route::prefix('plat')->group(function(){
    Route::post('create',[PlatController::class,'store'])->name('create.plat');
    Route::get('liste',[PlatController::class,'liste'])->name('liste.plate');
    Route::put('edit/{id}',[PlatController::class,'update'])->name('edit.plat');
    Route::delete('delete/{plat}',[PlatController::class,'delete'])->name('delete.plat');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

