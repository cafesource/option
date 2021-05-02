<?php

use Illuminate\Support\Facades\Route;
use Cafesource\Option\Http\Livewire as Option;

Route::get('/', Option\Index::class)->name('index');