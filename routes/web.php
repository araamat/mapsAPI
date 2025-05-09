<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Postituste ressursid
Route::resource('posts', PostController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'posts.index',
        'create' => 'posts.create',
        'store' => 'posts.store',
        'show' => 'posts.show',
        'edit' => 'posts.edit',
        'update' => 'posts.update',
        'destroy' => 'posts.destroy',
    ]);

// Markerite ressursid
Route::resource('markers', MarkerController::class)
    ->middleware(['auth', 'verified'])
    ->names([
        'index' => 'markers.index',
        'create' => 'markers.create',
        'store' => 'markers.store',
        'show' => 'markers.show',
        'edit' => 'markers.edit',
        'update' => 'markers.update',
        'destroy' => 'markers.destroy',
    ]);

// Kommentaaride lisamine ja kustutamine
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');

Route::controller(CartController::class)
    ->middleware('auth')
    ->prefix('/cart')
    ->name('cart.')
    ->group(function () {
        Route::post('/add/{product}', 'add')->name('add');  
        Route::get('/', 'view')->name('checkout');
        Route::post('/clear', 'clear')->name('clear'); 
        Route::post('/update', 'update')->name('update');

});

// 5 ülesanne ise

Route::get('/movies', [MovieController::class, 'index'])->middleware('auth')->name('movies.index');




// Lisaroute'id
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
