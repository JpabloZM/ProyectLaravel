<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación
Auth::routes();

// Rutas de productos y categorías (públicas - solo visualización)
Route::prefix('shop')->name('shop.')->group(function () {
    // Rutas públicas (visualización)
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    
    // Rutas protegidas (crear, editar, eliminar)
    Route::middleware('auth.custom')->group(function () {
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
});

// Rutas del Blog (protegidas y públicas)
Route::prefix('blog')->name('blog.')->group(function () {
    // Rutas públicas
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('categories', [BlogCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{category}', [BlogCategoryController::class, 'show'])->name('categories.show');
    
    // Rutas protegidas
    Route::middleware('auth.custom')->group(function () {
        Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
        Route::post('articles', [ArticleController::class, 'store'])->name('articles.store');
        Route::get('articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
        Route::put('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
        Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
        
        Route::resource('categories', BlogCategoryController::class)->except(['index', 'show']);
        Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('articles.comments.store');
        Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
