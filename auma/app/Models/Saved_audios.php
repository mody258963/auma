<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saved_audios extends Model
{
    use HasFactory;

    protected $fillable = [
       'audio_id'
    ];
}
