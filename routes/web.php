<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'app')->name('companies');

Route::view('company/{company}', 'app')->name('company');
