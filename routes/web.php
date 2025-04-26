<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\InvoiceController;
use App\Models\Items;

Route::get('/', [ItemsController::class, 'getItemPage'])->name('home');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthentificationController::class, 'getLoginPage'])->name('login');
Route::get('/register', [AuthentificationController::class, 'getRegisterPage'])->name('register');
Route::post('/register', [AuthentificationController::class, 'register'])->name('register.post');
Route::post('/login', [AuthentificationController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthentificationController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/add-item', [ItemsController::class, 'getCreatePage'])->name('add-item');
    Route::post('/add-item', [ItemsController::class, 'createItem'])->name('add-item.post');
    Route::post('/items', [ItemsController::class, 'store'])->name('items.store');
    Route::get('/edit-item/{id}', [ItemsController::class, 'getEditPage'])->name('edit-item');
    Route::put('/edit-item/{id}', [ItemsController::class, 'editItem'])->name('edit-item.put');
    Route::delete('/delete-item/{id}', [ItemsController::class, 'deleteItem'])->name('items.delete');
});

// Route::get('/cart', [InvoiceController::class, 'viewCart']);
// Route::post('/cart/add', [InvoiceController::class, 'addToCart']);
// Route::put('/cart/update/{id}', [InvoiceController::class, 'updateCart']);
// Route::delete('/cart/remove/{id}', [InvoiceController::class, 'removeFromCart']);
// Route::post('/cart/checkout', [InvoiceController::class, 'checkOut']);
// Route::get('/invoices', [InvoiceController::class, 'getInvoices']);
// Route::get('/invoices/{id}', [InvoiceController::class, 'showInvoice']);

