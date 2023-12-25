<?php

namespace App\Http\Controllers;

use App\Http\Resources\AudioResourse;
use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseApiController;
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

    $this->success($this->formatMany($this->audioRepository->all(),
                                    'App\Http\Resources\AudioResourse'),
                                    'all data',
                                    200);

        // $audios = Audio::all();
        // return response()->json($audios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'file_path' => 'required',
            'lecture_id' => 'required',
        ]);

        $audio = $this->audioRepository->uplodefile($data);

        $data = AudioResourse::transformer($audio);
        
        return $this->success($data,"Created successfully",201);

        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string', // why we need title for audio ?
        //     'file_path' => 'required', // named it ifram bz you call ifram from toutube for example
        //     'duration' => 'numeric', // what is this??????  this blackbox not me
        //     ]);
        //    if( $validator->fails()){
        //         return response()->json(
        //             [
        //                 'success' => false,
        //                 'message' => 'Some thing faild',
        //             ],400
        //         );
        //    }

        // i take path
        // how to store path
        // this string ?????

        // $file = $request->file('file_path');
        // $audio = Audio::create($request->all());// l3bt f deh
        // $path =  $file->store('public/audios'); // here i stored in the public in storge
        // $path = str_replace('public','storage',$path);
        // $audio->file_path = $path;



        // okay but you validate in this failed ("required|string") ???
        // how can i store string ??
        // i need file

        //TODO resource //
        // format response
    //      return response()->json([
    //         'success' => true,
    //         'message' => 'Audio created successfully',
    //         'data' => [
    //             'id' => $audio->id,
    //             'title' => $audio->title ,
    //             'duration' => $audio->duration,
    //             'audio' => env("APP_URL"). '/'. $audio->file_path,
    //         ]
    //     ], 201);
     }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $audio = Audio::find($id);
        return response()->json($audio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $audio = Audio::findOrFail($id);
        $audio->update($request->all());
        return response()->json($audio, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        Audio::destroy($id);
        return response()->json(null, 204);
    }
}
