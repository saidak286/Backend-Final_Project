<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
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
# get all resource
Route::get('/patients', [PatientController::class, 'index'])->middleware('auth:sanctum');
# Route post endpoint patients
Route::post('/patients', [PatientController::class, 'store']);
# get detail resource
Route::get('/patients/{id}', [PatientController::class, 'show']);
# update resource
Route::put('/patients/{id}', [PatientController::class, 'update']);
# delete resource
Route::delete('/patients/{id}', [PatientController::class, 'destroy']);
# get searched resource
Route::get('/patients/search/{name}', [PatientController::class, 'search']);
# get status resource
Route::get('/patients/status/{status}', [PatientController::class, 'searchByStatus']);

# Route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);