<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Index;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// goes straight to view, code behind doesn't run:
//Route::view('/', 'livewire.home')->name('home');

// pulls the livewire class instead, can use code behind then
Route::get('/', Index::class)->name('home');
