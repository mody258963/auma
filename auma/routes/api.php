<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\CourseController;

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



// Route::get('tt',function (){
//  return 'asdfvv';
// });

Route::get('/courses', [CourseController::class, 'index']);

Route::post('/create', [CourseController::class, 'store']);

Route::get('/courses/{course}', [CourseController::class, 'show']);

Route::put('/courses/{course}', [CourseController::class, 'update']);

Route::delete('/courses/{course}', [CourseController::class, 'destroy']);


// audios
Route::get('/audios', [AudioController::class, 'index']);
Route::get('/audios/{id}', [AudioController::class, 'show']);
Route::post('/audios', [AudioController::class, 'store']);
Route::put('/audios/{id}', [AudioController::class, 'update']);
Route::delete('/audios/{id}', [AudioController::class, 'destroy']);
