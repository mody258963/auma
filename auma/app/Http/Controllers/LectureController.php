<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Http\Resources\LectureResourse;
use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Lecture\LectureRepository;

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
    public function store(Request $request)
    {
        $lecture = Lecture::create($request->all());
        return response()->json($lecture, 201);

    }


    /**
     * Display the specified resource.
     */
    public function show(Lecture $lecture)
    {
        // return response()->json($lecture);
        return LectureResourse::make($lecture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecture $lecture)
    {
        $lecture->update($request->all());
        return response()->json($lecture);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return response()->json(null, 204);
    }}
