<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

// Ruta de prueba
Route::get('/test-blog', function() {
    return 'Blog route is working!';
});

Route::get('/blog-test', function() {
    return view('blog.test');
});

// Rutas de productos y categorías
Route::prefix('shop')->name('shop.')->group(function () {
    Route::resource('products', ProductController::class)->names('products');
    Route::resource('categories', CategoryController::class)->names('categories');
});

// Rutas del Blog
Route::prefix('blog')->name('blog.')->group(function () {
    Route::resource('categories', BlogCategoryController::class);
    Route::resource('articles', ArticleController::class);
    Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('articles.comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});
