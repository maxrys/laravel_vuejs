<?php

use App\Http\Controllers\ShortLinks;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/short_links/generate', function () {
    return view('short_links-vue');
})->name('short_links_generate');

Route::get('/short_links/test_manual', function () {
    return view('short_links-test_manual');
})->name('short_links_test_manual');

Route::post('/short_links/api/generate',
    [ShortLinks::class, 'generate']
)->name('short_links_api_generate');

Route::get('/short_links/go/{hash}',
    [ShortLinks::class, 'go']
)->name('short_links_go');

Route::get('{path}/{hash}',
    [ShortLinks::class, 'goAny']
)->where('path', '.*')
 ->where('hash', '[a-zA-Z0-9]{6}')->name('short_links_go_any');
