<?php


use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AudioController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Models\Lecture;
use GuzzleHttp\Client;

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
Route::post('/create/{userId}', [CourseController::class, 'addcourse']);
Route::get('/courses/{userId}', [CourseController::class, 'show']);
Route::put('//courses/{userId}', [CourseController::class, 'update']);
Route::delete('/courses/{userId}', [CourseController::class, 'destroy']);




Route::get('/audios', [AudioController::class, 'index']);
Route::get('/audios-show/{id}', [AudioController::class, 'show']);
Route::get('/get-audios/lecture/{lectureid}', [AudioController::class, 'getaudiowithlecture']);
Route::post('/audios/store/{id}', [AudioController::class, 'store']);
Route::post('/audios-update/{id}', [AudioController::class, 'update']);
Route::delete('/audios-delete/{id}', [AudioController::class, 'destroy']);





Route::post('/user/{user}/favorite/{course}', [FavoriteController::class, 'addFavorite']);

    Route::get('/all-user', [AuthController::class, 'index']);
    Route::post('/admin/register', [AuthController::class, 'adminRegister']);
    Route::post('/email/change/{id}', [AuthController::class, 'emailupdate']);
    Route::post('/user/login', [AuthController::class, 'login']);
    Route::post('/password/forget-password', [AuthController::class, 'forgetPassword']);
    Route::delete('/user-delete/{id}', [AuthController::class, 'destroy']);
    Route::get('/search/teacher/{name}',[AuthController::class, 'searchteacher']);



Route::post('/user/register', [AuthController::class, 'userRegister']);
Route::post('/teacher/register', [AuthController::class, 'teacherRegister']);



Route::get('/get/category', [CategoryController::class, 'index']);
Route::get('/get/category/{category}', [CategoryController::class, 'getcategorybyname']);
Route::post('/add/category', [CategoryController::class, 'addcategory']);
Route::post('/update/category/{id}', [CategoryController::class, 'updatecategory']);
Route::delete('/category-delete/{id}', [CategoryController::class, 'destroy']);
//seach
 Route::get('/search/category/{title}',[CategoryController::class, 'searchcategory']);



//course
Route::get('/get-all/course', [CourseController::class, 'index']);
Route::get('/get-course/teacher/{id}', [CourseController::class, 'getcoursebyteacherid']);
Route::get('/get-course/user/{id}', [CourseController::class, 'getcoursesEnrolledbyuser']);
Route::get('/get-user/course/{id}', [CourseController::class, 'getusersEnrolledbycourses']);
Route::get('/get-user/favertos-course/{id}', [CourseController::class, 'getfaverotofuser']);  //getfaverotofuser
Route::get('/get-courses/category/{id}', [CourseController::class, 'getcoursebycategoryid']); // enrollingInaCoursebyuser
Route::post('/add-course/{category}/{teacher}', [CourseController::class, 'addcoursefromteacher']);
Route::post('/add-course/user/{userid}/{courseid}', [CourseController::class, 'enrollingInaCoursebyuser']);
Route::post('/add-course/user-faverout/{userid}/{courseid}', [CourseController::class, 'addingtoFavertos']);
Route::delete('user/{userId}/favorite/{courseId}', [CourseController::class, 'deleteFavoriteOfUser']);
Route::post('/update-course/{id}', [CourseController::class, 'updatecourse']);
Route::delete('/course-delete/{id}', [CourseController::class, 'destroy']);

      //search
Route::get('/search/course/{title}',[CourseController::class, 'searchcourse']);



    //lecture
Route::get('/get-all/lecture', [LectureController::class, 'index']);
Route::get('/get-all/lecture/{courseid}', [LectureController::class, 'getlecturebycourseid']);
Route::delete('/lecture-delete/{id}', [LectureController::class, 'destroy']);
Route::post('/add-lecture/{courseid}', [LectureController::class, 'addlecture']);
Route::post('/update-lecture/{id}', [LectureController::class, 'update']);








<<<<<<< HEAD




=======

// rset passwerd ya 3m


// Route::post('/user/{user}/favorite/{course}', [FavoriteController::class, 'addFavorite']);
>>>>>>> 0fce94d033a1b85425edba99a89b50fd36fa8bde

Route::get('/soso/', function(){
    $client = new Client();
    $data = $client->get('http://127.0.0.1:5000/use_image');
    $data_body = $data->getBody();

    $api =  $data_body;
    return $api;
});