<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', function () {
    return redirect('http://localhost:8080/login');
})->name('login');