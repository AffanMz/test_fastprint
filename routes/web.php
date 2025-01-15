<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

// Collect data form API ##
Route::get('/collect-product', [ProductController::class, 'collectProductItem'])->name('collect.product');

// Landing Page ##
Route::get('/', [ProductController::class, 'index'])->name('view.product');

// CRUD produk ##
Route::post('/create-product', [ProductController::class, 'createProduct'])->name('create.product');
Route::put('/edit-product', [ProductController::class, 'editProduct'])->name('edit.product');
Route::delete('/delete-product', [ProductController::class, 'deleteProduct'])->name('delete.product');

// GET data produk for update produk ##
Route::get('/getDataEdit/{id}', [ProductController::class, 'collectProductEdit'])->name('collect.productEdit');

// CRUD category ##
Route::post('/create-category', [CategoryController::class, 'createCategory'])->name('create.category');
Route::put('/edit-category', [CategoryController::class, 'editCategory'])->name('edit.category');
Route::delete('/delete-category', [CategoryController::class, 'deleteCategory'])->name('delete.category');

// GET data kategori for update kategori ##
Route::get('/getCategoryEdit/{id}', [CategoryController::class, 'collectCategoryEdit'])->name('collect.categoryEdit');

// CRUD category ##
Route::post('/create-status', [StatusController::class, 'createStatus'])->name('create.status');
Route::put('/edit-status', [StatusController::class, 'editStatus'])->name('edit.status');
Route::delete('/delete-status', [StatusController::class, 'deleteStatus'])->name('delete.status');

// GET data kategori for update kategori ##
Route::get('/getStatusEdit/{id}', [StatusController::class, 'collectStatusEdit'])->name('collect.statusEdit');