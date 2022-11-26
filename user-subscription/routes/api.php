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

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\SubscriptionController;

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::get('/cronsubscribe', [SubscriptionController::class, 'cronSubscribe']);

Route::group(['middleware' => ['auth:sanctum']], function () {
Route::get('/user', [UserController::class, 'listUser']);
Route::put('/user', [UserController::class, 'updateUser']);
Route::delete('/user', [UserController::class, 'deleteUser']);

Route::post('/plan', [PlanController::class, 'createPlan']);
Route::get('/plan', [PlanController::class, 'listPlan']);
Route::put('/plan', [PlanController::class, 'updatePlan']);
Route::delete('/plan', [PlanController::class, 'deletePlan']);

Route::post('/subscribe', [SubscriptionController::class, 'createSubscribe']);
Route::put('/subscribe', [SubscriptionController::class, 'updateSubscribe']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
