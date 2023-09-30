<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SalonController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RecordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/salon', [SalonController::class, 'index_api']);
Route::post('/salon', [SalonController::class, 'store']);

Route::get('/service/{salon_id?}', [ServiceController::class, 'index']);
Route::post('/service', [ServiceController::class, 'store']);

Route::get('/record', [RecordController::class, 'index']);
Route::post('/record', [RecordController::class, 'store']);

Route::get('/available-records/{serviceId}/{date}', [RecordController::class, 'getAvailableRecords']);