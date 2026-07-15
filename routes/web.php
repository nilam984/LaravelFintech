<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', function () {
    return view('Auth.login');
});

Route::get('admin/dashboard', function () {
    return view('dashboard.admin');
});

Route::get('user/dashboard', function () {
    return view('dashboard.user');
});
