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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/get-tvshows', 'SpaController@getTvShows');
Route::get('/get-categories', 'SpaController@getCategories');
Route::get('/get-status', 'SpaController@getStatus');
Route::get('/get-years', 'SpaController@getYear');
Route::post('/save-tvshow', 'SpaController@saveTvshow');
Route::put('/update-tvshow/{id}', 'SpaController@updateTvshow');
Route::delete('/delete-tvshow/{id}', 'SpaController@destroy');

