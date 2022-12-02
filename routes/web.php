<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

Route::middleware('isguest')->group(function() {
    // Route::get('/reglog',[TodoController::class, 'reglog']);
    // Route::post('/reglog/input',[TodoController::class, 'registerAccount'])->name('reglog.input');
    // Route::post('/login/auth',[TodoController::class, 'auth']) ->name ('login.auth');

    Route::get('/logreg',[TodoController::class, 'logreg']);
    Route::post('/logreg/input',[TodoController::class, 'registerAccount'])->name('logreg.input');
    Route::post('/login/auth',[TodoController::class, 'auth']) ->name ('login.auth');
 
});

Route::middleware('islogin')->group(function() {
   Route::get('/todo', [TodoController::class, 'index'])->name('todo.index');
   Route::get('/create',[TodoController::class, 'create']) ->name ('create');
   Route::post('/store', [TodoController::class, 'store'])->name('store');
   Route::get('/logout',[TodoController::class, 'logout']) ->name ('logout');
   Route::get('/edit/{id}', [TodoController::class, 'edit']) ->name('edit');
   //mengubah route untuk ubah data di db itu patch/put
   Route::patch('/update/{id}', [TodoController::class, 'update']) ->name('update');
   Route::get('/delete/{id}', [TodoController::class, 'destroy']) ->name('delete');
   Route::patch('/complated/{id}', [TodoController::class, 'updateComplated']) ->name('update-complated');
});







