<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemController;
use App\Models\Items;

Route::get('/', function () {
    $items = Items::with('category')->get(); // load data item dan relasi kategori
    return view('home', compact('items')); // tanpa controller
});

Route::get('/', function () {
    return view('HomePage');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', [AuthentificationController::class, 'getLoginPage']);
Route::get('/register', [AuthentificationController::class, 'getRegisterPage']);
Route::post('/register', [AuthentificationController::class, 'register']);
Route::post('/login', [AuthentificationController::class, 'login']);
Route::post('/logout', [AuthentificationController::class, 'logout']);

Route::get('/items', [ItemsController::class, 'getItemPage']);
Route::get('/items/create', [ItemsController::class, 'getCreatePage']);
Route::post('/items', [ItemsController::class, 'createItem']);
Route::get('/items/edit/{id}', [ItemsController::class, 'getEditItem']);
Route::post('/items/update/{id}', [ItemsController::class, 'editItem']);
Route::delete('/items/delete/{id}', [ItemsController::class, 'deleteItem']);
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/create-item', [ItemsController::class, 'create'])->name('items.create');
    Route::post('/create-item', [ItemsController::class, 'store'])->name('items.store');

    Route::get('/edit-item/{id}', [ItemsController::class, 'edit'])->name('items.edit');
    Route::put('/edit-item/{id}', [ItemsController::class, 'update'])->name('items.update');
});

Route::get('/cart', [InvoiceController::class, 'viewCart']);
Route::post('/cart/add', [InvoiceController::class, 'addToCart']);
Route::put('/cart/update/{id}', [InvoiceController::class, 'updateCart']);
Route::delete('/cart/remove/{id}', [InvoiceController::class, 'removeFromCart']);
Route::post('/cart/checkout', [InvoiceController::class, 'checkOut']);
Route::get('/invoices', [InvoiceController::class, 'getInvoices']);
Route::get('/invoices/{id}', [InvoiceController::class, 'showInvoice']);

