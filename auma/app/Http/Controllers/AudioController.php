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

<<<<<<< HEAD
        $path = $request->file('file_path')->storePublicly('public/image');

=======
        
        $path = $request->file('file_path')->storePublicly('public/images');
        // $path = Storage::disk('public')->put('uploads', $file);
        // $data['file_path'] = $path;
>>>>>>> 0fce94d033a1b85425edba99a89b50fd36fa8bde
        $data = $request->validate([
            'title' => 'required',
        ]);
        $data['lecture_id'] = $id;
        $data['file_path']= "https://aumalaravel.s3.amazonaws.com/$path";

         $audio = $this->audioRepository->create($data);

         $data = AudioResourse::transformer($audio);

        return response()->json($data);


     }

    public function show($id)
    {
        $audio = Audio::find($id);
        return response()->json($audio);
    }




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
            $filePath = str_replace('https://aumalaravel.s3.amazonaws.com/', '', $currentFilePath);
            Storage::disk('s3')->delete($filePath);
        }


        $path = $request->file('file_path')->storePublicly('public/image');
        $audio->file_path = "https://aumalaravel.s3.amazonaws.com/$path";
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







