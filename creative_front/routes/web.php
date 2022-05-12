<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

//Route::get('/home', function ()
//{
//    return view()
//})

Route::get('/new_event', function (){
    return view('new_event');
});

Route::get('/admin_pan', [Controller::class, 'handle_admin'])->middleware('session_alive');
Route::get('/stage', [Controller::class, 'show_stages_acceptor'])->middleware('session_alive');
Route::get('/stage_requester', [Controller::class, 'show_stages_requester'])->middleware('session_alive');
Route::get('/show_event_details', [Controller::class, 'show_event_details'])->middleware('session_alive');
Route::get('/show_entry', [Controller::class, 'show_entry_details'])->middleware('session_alive');
Route::post('/handle_new_entry', [Controller::class, 'handle_new_entry']);
Route::get('/insert_new_entry', [Controller::class, 'insert_new_entry'])->middleware('session_alive');
Route::get('/home', [Controller::class, 'show_home'])->middleware('session_alive');
Route::get('/accept_request', [Controller::class, 'accept_request'])->middleware('session_alive');

Route::post('/change_status', [Controller::class, 'change_status_handle']);
Route::post('/upload_request_photo', [Controller::class, 'add_request_photo']);
Route::post('/handle_marks', [Controller::class, 'handle_marks']);
Route::post('/handle_new_request', [Controller::class, 'handle_new_request']);
Route::post('/create_event', [Controller::class, 'handle_create_event']);

Route::get('/logout', [Controller::class, 'logout']);


Route::post('/set_price', [Controller::class, 'set_price'])->middleware('session_alive');

Route::post('/auth_login', [Controller::class, 'auth_login']);

Route::get('/register', function ()
{
    return view('register');
});

Route::post('/handle_register', [Controller::class, 'handle_register']);

Route::get('/hash_value', function ()
{
    return \Illuminate\Support\Facades\Hash::make('12345678');
});
