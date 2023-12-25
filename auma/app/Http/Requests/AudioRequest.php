<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Models\Audio;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
class AudioRequst extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string', // why we need title for audio ?
            'file_path' => 'required', // named it ifram bz you call ifram from toutube for example 
            'duration' => 'numeric', // what is this??????  this blackbox not me 
              ];




    }


}
