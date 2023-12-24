<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        $courses = Lecture::all();
        return response()->json($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $course = Lecture::create($request->all());
        return response()->json($course, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Lecture $course)
    {
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecture $course)
    {
        $course->update($request->all());
        return response()->json($course);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $course)
    {
        $course->delete();
        return response()->json(null, 204);
    }}
