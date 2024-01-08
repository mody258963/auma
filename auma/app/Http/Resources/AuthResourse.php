<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class AuthResourse extends JsonResource
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

    public static function transformer(User $user){

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email ,
            'image' => env('APP_URL') . '/' . $user->image,
            'password' =>  Hash::make($user->password),
            'is_blocked' => $user->is_blocked , 
            'is_accepted' => $user->is_accepted,
            'social_link' => $user->social_link , 
            'role' => $user->role

        ];
    }

}
