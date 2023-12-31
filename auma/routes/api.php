<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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


// audios ya s7by shyfny


Route::get('/audios', [AudioController::class, 'index']);
Route::get('/audios-show/{id}', [AudioController::class, 'show']);
Route::post('/audios/store', [AudioController::class, 'store']);
Route::post('/audios-update/{id}', [AudioController::class, 'update']);
Route::delete('/audios-delete/{id}', [AudioController::class, 'destroy']);


Route::get('/all-user', [AuthController::class, 'index']);
Route::post('/user/register', [AuthController::class, 'userRegister']);
Route::post('/teacher/register', [AuthController::class, 'teacherRegister']);
Route::post('/admin/register', [AuthController::class, 'adminRegister']);
Route::post('/email/change/{id}', [AuthController::class, 'emailupdate']);
Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/delete/{id}', [AuthController::class, 'destroy']);


Route::get('/get/category', [CategoryController::class, 'index']);
Route::get('/get/category/name', [CategoryController::class, 'getcategorybyname']);
Route::post('/add/category', [CategoryController::class, 'addcategory']);
Route::post('/update/category/{id}', [CategoryController::class, 'updatecategory']);


Route::get('/get/course', [CourseController::class, 'index']);
Route::get('/get/{user}/courses', [CourseController::class, 'getCoursebyuserid']);
Route::post('/add/course', [CourseController::class, 'addcourse']);
Route::post('/update/course/{id}', [CourseController::class, 'updatecourse']);
