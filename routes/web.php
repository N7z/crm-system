<?php

use App\Http\Controllers\SaleController;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('clients', 'clients/index')->name('clients.index');
    Volt::route('clients/create', 'clients/create')->name('clients.create');
    Volt::route('clients/{client}/edit', 'clients/edit')->name('clients.edit');

    Volt::route('categories', 'categories/index')->name('categories.index');
    Volt::route('categories/create', 'categories/create')->name('categories.create');
    Volt::route('categories/{category}/edit', 'categories/edit')->name('categories.edit');

    Volt::route('suppliers', 'suppliers/index')->name('suppliers.index');
    Volt::route('suppliers/create', 'suppliers/create')->name('suppliers.create');
    Volt::route('suppliers/{supplier}/edit', 'suppliers/edit')->name('suppliers.edit');

    Volt::route('products', 'products/index')->name('products.index');
    Volt::route('products/create', 'products/create')->name('products.create');
    Volt::route('products/{product}/edit', 'products/edit')->name('products.edit');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
