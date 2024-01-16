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




    public function addcoursefromteacher(Request $request,$category) {
        $data = Validator::make($request->all(), [
            'title' => 'required', 
            'description' => 'required'
            ])->validate();
            $data['category_id'] = $category; 
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
        return $tacher->course;

    }


    public function getcoursebycategoryid($id){
        $category = Category::find($id);
        return $category->course;

    }

    public function enrollingInaCoursebyuser($userid,$courseid){
        $user = User::find($userid);
        $course = Course::find($courseid);

        $user->courses()->attach($course->id);

        return response()->json(['message' => 'Role assigned to user successfully']);

    }

    public function getcourseEnrolledbyuser($id){
        $user = User::find($id);
       return $user->courses;

    }
    public function getusersEnrolledbycourses($id){
        $course = $this->courseRepository->find($id);
       return $course->users;

    }

}
