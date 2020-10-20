<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Up & Running Code samples Chapter 1 and 2
|--------------------------------------------------------------------------
|
| Saving the code samples and trying them when possible
|theses are for the web.php file
*/

//Default Route with laravel
Route::get('/', function () {
    return view('welcome');
});

//Page 27, Static Calls -- Same thing as what is above
$router->get('/', function () {
    return 'Hello, World!';
});


//Ex 1-1 - Worked
Route::get('/', function () {
    return 'Hello, World!';
});

//Ex 1-2; 3-4 - Didn't work
Route::get('/', 'WelcomeController@index');
// -> Page 29 'tuple' syntax
Route::get('/', [WelcomeController::class, 'index']);

//Ex 1-3 - Didn't work
use App\Greeting;

Route::get('create-greeting', function () {
    $greeting = new Greeting;
    $greeting->body = 'Hello, World!';
    $greeting->save();
});
Route::get('first-greeting', function () {
    return Greeting::first()->body;
});

