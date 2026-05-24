<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactShowController;
use App\Http\Controllers\ContactStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SeriesController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/portfolio', PortfolioController::class)->name('portfolio.index');
Route::get('/portfolio/{series:slug}', SeriesController::class)->name('portfolio.show');

Route::get('/contact', ContactShowController::class)->name('contact.show');
Route::post('/contact', ContactStoreController::class)
    ->middleware('throttle:5,1')
    ->name('contact.store');
