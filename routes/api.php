<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\HotelController;

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

Route::post('registrar',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);




Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('logout',[AuthController::class,'logout']);

    //#### HOTEL ####
    Route::get('all/hotel',[HotelController::class,'index']);
    Route::post('store/hotel',[HotelController::class,'store']);
    Route::get('show/{id}/hotel',[HotelController::class,'show']);
    Route::put('update/{id}/hotel',[HotelController::class,'update']);
    Route::delete('destroy/{id}/hotel',[HotelController::class,'destroy']);

    //#### HABITACIONES #### //
    Route::get('all/{id}/hotelWithRooms',[RoomController::class,'hotelWithRooms']);
    Route::post('store/room',[RoomController::class,'store']);
    Route::get('show/{id}/room',[RoomController::class,'show']);
    Route::put('update/{id}/room',[RoomController::class,'update']);
    Route::delete('destroy/{id}/room',[RoomController::class,'destroy']);
    Route::post('assignRoomTypeAccommodations/{id}/room',[RoomController::class,'assignRoomTypeAccommodations']);


});
