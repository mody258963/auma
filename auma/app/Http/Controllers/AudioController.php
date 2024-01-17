<?php

namespace App\Http\Controllers;

use App\Http\Resources\AudioResourse;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\AudioRequest;
use App\Models\Course;
use App\Models\Lecture;
use App\Repositories\Audio\AudioRepository;

// look here
// i have many courses
// every course has many lectures -> their is no lectures -- lestien form me i know your idea be flixable
// every lecture has audios or files or videos
// any thing i add type of media over all
// this type i response with it to front end to represent this content
// then i need add leacture with title and option description
// overall i have three entities
// user -> (admin, instructor, student or user)
// course (has many lectures) columns:(title, description, sub_description, cover, short video)
// leactures (has mmany contents and belongs to course) columns: (name, description(option))
// contents (belongs to lectures) columns:(content(video, audio, file),type of media)

// that is very simple to generate this system without any complexity

// sorry
// uploding file give it a look please :)   are you still here// i here
// okay
// revesion theses comments



class AudioController extends BaseApiController
{
    public function __construct(private AudioRepository $audioRepository)
    {
        $this->audioRepository = $audioRepository;
    }
    public function index()
    {
        return $this->success(
            $this->formatMany(
                $this->audioRepository->all(),
                'App\Http\Resources\AudioResourse'
            ),
            "categories retreived succssefully",
            200
        );


    }


    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required',
            'file_path' => 'required',
        ]);

        $audio = $this->audioRepository->uplodefile($data);

        $data = AudioResourse::transformer($audio);

        return response()->json($data);


     }

    public function show($id)
    {
        $audio = Audio::find($id);
        return response()->json($audio);
    }


    public function update(Request $request , $id)
    {
        $data = Validator::make($request->all(), [
                'title' => 'required|string', // why we need title for audio ?
                'file_path' => 'required|file',
                'lecture_id' => 'required',
                'duration' => 'numeric', // what is this??????  this blackbox not me

                ])->safe()->all();
        $audio = $this->audioRepository->find($id);


     $data =  $this->audioRepository->updatefile($data,$audio);



        return $this->success($this->formatMany(
            $this->audioRepository->all(),
        'App\Http\Resources\AudioResourse'),
        'Updated Succesfully',201);

    }

    public function getaudiowithcourse($lectureid){
        $lecture = Lecture::find($lectureid);
        $audio = $lecture->audio;
        $data = $this->formatMany($audio,'App\Http\Resources\AudioResourse');
        return response()->json($data);
    }

    public function destroy($id)
    {
        $audio = $this->audioRepository->find($id);
        $this->audioRepository->delete($audio);
        return $this->success($this->formatMany(
            $this->audioRepository->all(),
        'App\Http\Resources\AudioResourse'),
        'Updated Succesfully',201);
    }



   
}
