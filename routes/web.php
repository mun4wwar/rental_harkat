<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('harkat-rental');


require __DIR__ . '/auth.php';
require __DIR__ . '/auth_admin.php';
require __DIR__ . '/auth_supir.php';
