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


//Api/V1
//localhost:8000/api/v1/movies ---> for index all movies
//localhost:8000/api/v1/users  ---> for index all users
//localhost:8000/api/v1/movies/1 --> for show one movie :) id is change as we wish 

// public Routes
Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\Api\V1'],function(){
    // Route::apiResource('movies',MovieApiController::class);
    Route::get('movies',['uses'=>'MovieApiController@index']);//Movies Index  
    Route::get('movies/{movie}',['uses'=>'MovieApiController@show']);// Movies Show

    //request: username,email,password,password_confirmation,image , response will e as like: 
    // {"user":{"username":"laila","email":"lailaibrahim798@gmail.com","image":{},"updated_at":"2022-12-30T20:39:48.000000Z","created_at":"2022-12-30T20:39:48.000000Z","id":1},"token":"1|FS6PhGLep2TiFFdFmhooUTpZiyeGt1dfgS5cuZQq"}
    Route::post('register',['uses'=>'UserApiController@register']);//register

    Route::post('login',['uses'=>'UserApiController@login']);//Login


});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Protected Routes
//['middleware'=>['auth:sanctum']
Route::group(['prefix'=>'v1','namespace'=>'App\Http\Controllers\Api\V1'],function(){
    Route::post('movies',['uses'=>'MovieApiController@store']);// Movies Store

    Route::put('movies/{movie}',['uses'=>'MovieApiController@update']);//Movies Update

    Route::delete('movies/{movie}',['uses'=>'MovieApiController@destroy']);//Movies Destroy

    // logout
     Route::post('logout',['uses'=>'UserApiController@logout']);
     // Route::apiResource('users',UserApiController::class); 
     Route::get('users',['uses'=>'UserApiController@index']);//Users Index
     //Route::post('users',['uses'=>'UserApiController@store']);//Users Store
     //Route::get('users/{user}',['uses'=>'UserApiController@show']);//Users show
     Route::put('users/{user}',['uses'=>'UserApiController@update']);//Users Update
    // Route::delete('users/{user}',['uses'=>'UserApiController@destroy']);//Users Destroy
  
    //add Movie Show-Time to specific Movie
    Route::post('{movie}/addmovieShowTime',['uses'=>'MovieApiController@addmovieShowTime']);

    // Book A ticket For Specific Movie
    Route::post('{movie}/bookTicket',['uses'=>'MovieApiController@bookTicket']);//->middleware('auth')

    // Export All Movies Into Excel
    Route::get('exportIntoExcel',['uses'=>'MovieApiController@exportIntoExcel']);

    // Export All Movies Into CSV
    Route::get('exportIntoCSV',['uses'=>'MovieApiController@exportIntoCSV']);

    // Export Specific User-Movie Details into Excel
    Route::get('{movie}/exportExcel',['uses'=>'MovieApiController@exportExcel']);

    // Export Specific User-Movie Details into CSV
    Route::get('{movie}/exportCSV',['uses'=>'MovieApiController@exportCSV']);

    // Export Specific User-Movie Details into Pdf
     Route::get('{movie}/DownloadPDF',['uses'=>'MovieApiController@DownloadPDF']);
 


});