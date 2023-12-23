<?php

namespace App\Http\Controllers;

use App\Models\Audio;
use Illuminate\Http\Request;

class AudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $audios = Audio::all();
        return response()->json($audios);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $file = $request->file('file_path'); 
          $audio = Audio::create($request->all());// l3bt f deh
        $audio->file_path = 'public/' . $file->store('audios'); // w deh
        return response()->json($audio, 201);
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
