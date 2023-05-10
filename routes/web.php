<?php

use App\Http\Controllers\PhonebookController;
use Illuminate\Support\Facades\Route;

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

Route::post('/add/contact',[PhonebookController::class,'addContact'])->name('add_new_contact');
Route::get('/',[PhonebookController::class,'contacts'])->name('dashboard');
Route::post('/update/contact',[PhonebookController::class,'updateContact'])->name('update_contact');
Route::post('/delete/contact',[PhonebookController::class,'deleteContact'])->name('delete_contact');
