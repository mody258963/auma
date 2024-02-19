<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseApiController;
use App\Models\Category;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Course\CourseRepository;
use Illuminate\Support\Facades\Validator;


class CourseController extends BaseApiController
{
    public function __construct(private CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        // return $this->success(
        //     $this->formatMany(
        //         $this->courseRepository->all(),
        //         'App\Http\Resources\CourseResourse'
        //     ),
        //     "categories retreived succssefully",
        //     200
        // );

        $data = $this->formatMany($this->courseRepository->all(), 'App\Http\Resources\AuthResourse');
        return response()->json($data);
    }




    public function addcoursefromteacher(Request $request,$category,$teacher) {
        $data = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'book' => 'required'
            ])->validate();
            $data['category_id'] = $category;
            $data['teacher_id'] = $teacher;
            $data = $this->courseRepository->create($data);

            return $this->success($data,'Cousre is added',201);

    }

    public function updatecourse(Request $request , $id) {
        $data = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            ])->validate();
            $Cousre = $this->courseRepository->find($id);


            $data = $this->courseRepository->update($Cousre,$data);

            return $this->success($data,'Cousre is added',201);

    }

    public function getcoursebyteacherid($id){
        $tacher = Teacher::find($id);
        return $this->formatMany($tacher->course, 'App\Http\Resources\CourseResourse');

    }


    public function getcoursebycategoryid($id){
        $category = Category::find($id);
         $category->course;
         return response()->json($category);

    }

    public function enrollingInaCoursebyuser($userid,$courseid){
        $user = User::find($userid);
        $course = Course::find($courseid);

        $user->courses()->attach($course->id);

        return response()->json(['message' => 'Role assigned to course successfully']);

    }

    public function addingtoFavertos($userid,$courseid){
        $user = User::find($userid);
        $course = Course::find($courseid);

        $user->course()->attach($course->id);

        return response()->json(['message' => 'Role assigned to course successfully']);

    }


    public function getfaverotofuser($id){
        $user = User::find($id);
       return $user->course;
    }

    public function deleteFavoriteOfUser($userId, $courseId)
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    
    $user->course()->detach($courseId);

    return response()->json(['message' => 'Course removed from favorites successfully'], 200);
}

    public function getcoursesEnrolledbyuser($id){
        $user = User::find($id);
       return $user->courses;

    }

    public function getusersEnrolledbycourses($id){
        $course = $this->courseRepository->find($id);
       return $course->users;

    }

    public function destroy($id){
        $course = $this->courseRepository->find($id);
        $this->courseRepository->delete($course);
        return $this->success($this->formatMany(
            $this->courseRepository->all(),
        'App\Http\Resources\courseResourse'),
        'Updated Succesfully',201);
    }

    function searchcourse($title)
    {
        $course = Course::where('title',"like","%".$title."%")->get();
        return response()->json($course);

    }

}
