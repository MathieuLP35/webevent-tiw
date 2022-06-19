<?php

use App\Http\Controllers\Event;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function(){

    Route::middleware(['auth:sanctum','verified'])->get('/dashboard',function (){
        return view('dashboard');
    })->name('dashboard');

    Route::get('event', [Event::class, 'index'])->name('event');
    Route::get('event/create', [Event::class, 'create'])->name('event.create');
    Route::post('event/store', [Event::class, 'store'])->name('event.store');
    Route::get('event/{id}/edit', [Event::class, 'edit'])->name('event.edit');
    Route::post('event/{id}/update', [Event::class, 'update'])->name('event.update');
    Route::get('event/{id}/delete', [Event::class, 'destroy'])->name('event.delete');
    Route::get('event/{id}/subscribe', [Event::class, 'registerEvent'])->name('event.subscribe');
    Route::get('event/{id}/unsubscribe', [Event::class, 'unregisterEvent'])->name('event.unsubscribe');
    Route::get('event/{id}/show', [Event::class, 'show'])->name('event.show');
});


require __DIR__.'/auth.php';


