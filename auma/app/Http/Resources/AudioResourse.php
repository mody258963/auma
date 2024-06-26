<?php

namespace App\Http\Resources;

use App\Models\Audio;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use  App\Http\Controllers\API\BaseApiController;
class AudioResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    return [
            'id' => $this->id,
            'title' => $this->title ,
            'audio' => $this->file_path,
        ];
    }

}
