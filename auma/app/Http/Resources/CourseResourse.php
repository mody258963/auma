<?php

namespace App\Http\Resources;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use  App\Http\Controllers\API\BaseApiController;
class CourseResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
