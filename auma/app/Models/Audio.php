<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;


    protected $table = 'audios';
    protected $fillable = [
        'title',
        'lecture_id',// hena 7tet course_id
        'file_path',
        'duration',


    ];

public function lecture()
{
  return $this->belongsTo(Lecture::class);
}


}
