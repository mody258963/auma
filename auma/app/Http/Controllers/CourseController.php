<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseApiController;
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
        return $this->success(
            $this->formatMany(
                $this->courseRepository->all(),
                'App\Http\Resources\CourseResourse'
            ),
            "categories retreived succssefully",
            200
        );


    }




    public function addcourse(Request $request,$category) {
        $data = Validator::make($request->all(), [
            'title' => 'required', 
            'description' => 'required'
            ])->validate();
            $data['category_id'] = 1 ; 
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

    public function test(Request $request){
        $user = User::find(1);
        return $user->courses;

    }
    public function show(Course $course){
    }
}
