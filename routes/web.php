<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;

use App\Http\Controllers\Login_Controller;

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

Route::get('/login', function () {
    // return view('login');
    if (Cookie::get('Username_server') != null) {
        // dd(Cookie::get('SMS_Username_server'));
        return redirect()->route('welcome');
    } else {
        Cookie::queue(Cookie::forget('Username_server'));
        return view('login');
    }
})->name('login');


Route::post('/Login_user', [Login_Controller::class, 'Login_user']);


Route::group(['middleware' => ['authLogin']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

});


Route::get('/oders', function () {
    return view('oders');
});

Route::get('/process', function () {
    return view('process');
});
