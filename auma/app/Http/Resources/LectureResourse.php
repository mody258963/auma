<?php

namespace App\Http\Resources;

use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectureResourse extends JsonResource
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
    public static function transformer(Lecture $lecture){

        return [
            'id' => $lecture->id,
            'title' => $lecture->title ,
            'description' => $lecture->description,
        ];
    }
}

