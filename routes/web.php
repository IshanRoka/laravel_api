<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/table', function () {
    return view('table');
});
Route::get('/form', function () {
    return view('insert');
});
