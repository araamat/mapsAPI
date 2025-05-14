<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

// Dashboard
Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Posts
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

// Markers
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

// Comments
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Products
Route::get('/products', [ProductController::class, 'index'])->middleware('auth')->name('products.index');

// Cart
Route::controller(CartController::class)
    ->middleware('auth')
    ->prefix('/cart')
    ->name('cart.')
    ->group(function () {
        Route::post('/add/{product}', 'add')->name('add');  
        Route::get('/', 'view')->name('checkout');
        Route::post('/clear', 'clear')->name('clear'); 
        Route::post('/update', 'update')->name('update');
        Route::delete('/remove', 'remove')->name('remove');
    });

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/payment/success', [CheckoutController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [CheckoutController::class, 'cancel'])->name('payment.cancel');

// --- MOVIES SECTION --- //

// Movie Inertia pages
Route::get('/movies', [MovieController::class, 'index'])->middleware('auth')->name('movies.index');
Route::get('/movies/create', [MovieController::class, 'create'])->middleware(['auth', 'verified'])->name('movies.create');
Route::post('/movies', [MovieController::class, 'store'])->middleware(['auth', 'verified'])->name('movies.store');

// Movie JSON API with search, sort, limit, cache
Route::get('/movies/data', [MovieController::class, 'api'])->middleware('auth')->name('movies.api');

// External movies (public API)
Route::get('/movies/external', [MovieController::class, 'external'])->middleware('auth')->name('movies.external');



Route::get('/api/movies', [MovieController::class, 'api']);



// Lisaroute'id
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
