<?php

use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('frontend.home');
Route::get('/services', [PageController::class, 'services'])->name('frontend.services.index');
Route::get('/services/{slug}', [PageController::class, 'serviceShow'])->name('frontend.services.show');
Route::get('/blog', [PageController::class, 'blog'])->name('frontend.blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('frontend.blog.show');
Route::get('/search', [PageController::class, 'search'])->name('frontend.search');
Route::get('/contact', [PageController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('frontend.contact.submit');
