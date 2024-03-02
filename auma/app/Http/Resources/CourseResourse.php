<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource (course model) into an array.
     *
     * This method defines how the course model is transformed and what attributes
     * are included in the responses where this resource is used.
     *
     * @param Request $request
     * @return array<string, mixed> The array representation of the course model.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'teacher_id' => (int) $this->teacher_id,
            'category_id' => (int) $this->category_id,
            'book' => $this->book,
            'image' => $this->image,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}