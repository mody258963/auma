<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Lecture\LectureRepository;
use Illuminate\Support\Facades\Validator;
class LectureController extends BaseApiController
{

    public function __construct(private LectureRepository $lectureRepository)
    {
        $this->lectureRepository = $lectureRepository;
    }

    public function index()
    {

        $data = $this->formatMany($this->lectureRepository->all(),'App\Http\Resources\LectureResourse');
        return response()->json($data);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function addlecture(Request $request,$courseid)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            ])->validate();
            $data['course_id'] = $courseid;

            $data = $this->lectureRepository->create($data);

            return $this->success($data,'Cousre is added',201);

    }

    public function getlecturebycourseid($courseid) {

        $course = Course::find($courseid);
        // $lecture->course;
        return $this->formatMany( $course->lecture, 'App\Http\Resources\LectureResourse');
    }


    public function update(Request $request,$id)
    {
        $data = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            ])->validate();
            $lecture = $this->lectureRepository->find($id);

            $data = $this->lectureRepository->update($lecture,$data);

            return $this->success($data,'Cousre is added',201);
    }


    public function destroy($id)
    {
        $lecture = $this->lectureRepository->find($id);
        $this->lectureRepository->delete($lecture);
        return $this->success($this->formatMany(
            $this->lectureRepository->all(),
        'App\Http\Resources\lectureResourse'),
        'Updated Succesfully',201);
    }





}
