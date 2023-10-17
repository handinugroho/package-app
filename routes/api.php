<?php

use App\Http\Controllers\PackageController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('package', '\App\Http\Controllers\PackageController@store');
Route::get('package', '\App\Http\Controllers\PackageController@index');
Route::get('package/{package}', '\App\Http\Controllers\PackageController@show');
// Route::put('package/{package}', '\App\Http\Controllers\PackageController@update');
// Route::patch('package/{package}', '\App\Http\Controllers\PackageController@patchUpdate');
