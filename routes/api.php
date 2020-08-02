<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// The following line contains: 
//     - GET method to 'api/booking' using BookingController@index()
//     - POST method to 'api/booking' using BookingController@store()
//     - GET method to 'api/booking/create' using BookingController@create()
//     - GET method to 'api/booking/{id}' using BookingController@show()
//     - PUT method to 'api/booking/{id}' using BookingController@update()
//     - DELETE method to 'api/booking/{id}' using BookingController@delete()
//     - GET method to 'api/booking/{id}/edit' using BookingController@edit()
Route::resource('booking', 'Api\BookingController');


//     - GET: 'api/customer': CustomerController@index()
//     - POST: 'api/customer': CustomerController@store()
//     - GET: 'api/customer/create': CustomerController@create()
//     - GET: 'api/customer/{id}': CustomerController@show()
//     - PUT: 'api/customer/{id}': CustomerController@update()
//     - DELETE: 'api/customer/{id}': CustomerController@delete()
//     - GET: 'api/customer/{id}/edit': CustomerController@edit()
Route::resource('customer', 'Api\CustomerController');


//     - GET: 'api/stylist': StylistController@index()
//     - POST: 'api/stylist': StylistController@store()
//     - GET: 'api/stylist/create': StylistController@create()
//     - GET: 'api/stylist/{id}': StylistController@show()
//     - PUT: 'api/stylist/{id}': StylistController@update()
//     - DELETE: 'api/stylist/{id}': StylistController@delete()
//     - GET: 'api/stylist/{id}/edit': StylistController@edit()
Route::resource('stylist', 'Api\StylistController');


//     - GET: 'api/treatment': TreatmentController@index()
//     - POST: 'api/treatment': TreatmentController@store()
//     - GET: 'api/treatment/create': TreatmentController@create()
//     - GET: 'api/treatment/{id}': TreatmentController@show()
//     - PUT: 'api/treatment/{id}': TreatmentController@update()
//     - DELETE: 'api/treatment/{id}': TreatmentController@delete()
//     - GET: 'api/treatment/{id}/edit': TreatmentController@edit()
Route::resource('treatment', 'Api\TreatmentController');
