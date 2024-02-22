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
use Illuminate\Support\Facades\Storage;

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


    public function store(Request $request,$id)
    {

        
        $path = $request->file('file_path')->storePublicly('public/images');
        // $path = Storage::disk('public')->put('uploads', $file);
        // $data['file_path'] = $path;
        $data = $request->validate([
            'title' => 'required',
        ]);
        $data['lecture_id'] = $id;
        $data['file_path']= "https://uamh-laravel.s3.amazonaws.com/$path";

         $audio = $this->audioRepository->create($data);

         $data = AudioResourse::transformer($audio);

        return response()->json($data);


     }

    public function show($id)
    {
        $audio = Audio::find($id);
        return response()->json($audio);
    }


    // public function update(Request $request , $id)
    // {
    //     $audio = $this->audioRepository->find($id);

    //     if($request['file_path']){
    //         // $file = $data['file_path'];
    //         $file =  Audio::find($id, ['file_path']);
    //         $var = $file['file_path'];
    //         $str = str_replace('https://uamh-laravel.s3.amazonaws.com/','',$var);
    //         Storage::disk('s3')->delete($str);

    //         $path = $request->file('file_path')->store('public/images');
    //         $data['file_path']= "https://uamh-laravel.s3.amazonaws.com/$path";
    //     }
    //     $data = Validator::make($request->all(), [
    //         'title' => 'required|string',
    //         'file_path' => 'required|file',
    //         ])->safe()->all();

    //         $data =  $this->audioRepository->update($audio, $data);

    //     return $this->success($this->formatMany(
    //         $this->audioRepository->all(),
    //     'App\Http\Resources\AudioResourse'),
    //     'Updated Succesfully',201);

    // }

    public function update(Request $request, $id)
{

    $audio = $this->audioRepository->find($id);


    $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'file_path' => 'required|file',
    ]);


    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    if ($request->hasFile('file_path')) {

        $currentFilePath = $audio->file_path;


        if ($currentFilePath) {
            $filePath = str_replace('https://uamh-laravel.s3.amazonaws.com/', '', $currentFilePath);
            Storage::disk('s3')->delete($filePath);
        }


        $path = $request->file('file_path')->storePublicly('public/images');
        $audio->file_path = "https://uamh-laravel.s3.amazonaws.com/$path";
    }


    $audio->title = $request->title;

    $audio->save();


    $audios = $this->audioRepository->all();
    $formattedAudios = $this->formatMany($audios, 'App\Http\Resources\AudioResourse');

    return response()->json([
        'audios' => $formattedAudios,
        'message' => 'Updated successfully'
    ], 200);
}


    public function getaudiowithlecture($lectureid){
        $lecture = Lecture::find($lectureid);
        $audio = $lecture->audio;
        $data = $this->formatMany($audio,'App\Http\Resources\AudioResourse');
        return response()->json($data);
    }

    public function destroy($id)
    {

        $audio = $this->audioRepository->find($id);

        return $this->success($this->formatMany(
            $this->audioRepository->all(),
        'App\Http\Resources\AudioResourse'),
        'Updated Succesfully',201);
    }




}
