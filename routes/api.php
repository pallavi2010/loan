<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\LoanController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('loan/all', [LoanController::class, 'index']);
    Route::post('loan/create', [LoanController::class, 'store']);
    Route::get('loan/show/{id}', [LoanController::class, 'show']);
    Route::post('loan/pay/{id}', [LoanController::class, 'pay']);
    Route::put('loan/update/{id}', [LoanController::class, 'update']);
});
Route::group(['middleware' => ['admin']], function () {
 

});


