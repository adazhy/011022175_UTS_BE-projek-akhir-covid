<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//membuat reote untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//RoutES Patient (UTS)
Route::middleware(['auth:sanctum'])->group(function () {

    //method get all resource
    Route::get('/patient', [PatientController::class, 'index']);

    //method add resource
    Route::post('/patient', [PatientController::class, 'store']);

    //method get detail resource
    Route::get('/patient/{id}', [PatientController::class, 'show']);

    //method edit resource
    Route::put('/patient/{id}', [PatientController::class, 'update']);

    //method delete resource
    Route::delete('/patient/{id}', [PatientController::class, 'destory']);

    //method search resource by name
    Route::get('/patient/search/{name}', [PatientController::class, 'search']);

    //method get positive resource
    Route::get('/patient/status/positive', [PatientController::class, 'positive']);

    //method get recoved resource
    Route::get('/patient/status/recovered', [PatientController::class, 'recovered']);

    //method get dead resource
    Route::get('/patient/status/dead', [PatientController::class, 'dead']);
        
});