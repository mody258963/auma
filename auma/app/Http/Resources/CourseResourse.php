<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }

    public static function transformer(Course $course){

        return [
            'id' => (int) $course->id,
            'title' => $course->title ,
            'description' => $course->description,
            'teacher_id' => $course->teacher_id,
            'category_id' => $course->category_id,
            'book' => $course->book


        ];
    }
}
