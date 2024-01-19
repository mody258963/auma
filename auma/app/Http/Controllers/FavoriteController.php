<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addFavorite(User $user, Course $course){

             $user->favorites()->attach($course->id);

             return response()->json(['message' => 'susss']);

    }
}
