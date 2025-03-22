<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TextController;
use App\Http\Controllers\ControlerProduct;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/TextController', [
    TextController::class,
    'test'
]);


Route::get('/api/v1/products', [
    ControlerProduct::class,
    'getProducts'
]);

Route::get('/api/v1/products/{id}', [
    ControlerProduct::class,
    'getProductItem'
]);

Route::post('/api/v1/products', [
    ControlerProduct::class,
    'createProduct'
])->withoutMiddleware([VerifyCsrfToken::class]);

Route::delete('/api/v1/products/{id}', [
    ControlerProduct::class,
    'deleteProduct'
])->withoutMiddleware([VerifyCsrfToken::class]);