<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// course (has many lectures) columns:(title, description, sub_description, cover, short video)
// leactures (has mmany contents and belongs to course) columns: (name, description(option))
class Lecture extends Model
{
    use HasFactory;

    protected $table = 'lectures';
    protected $fillable = [
        'name',
        'description',
        'course_id',

     
         ];


         public function audio()
{
  return $this->hasMany(Audio::class);
}

         public function course()
{
  return $this->belongsTo(Course::class);
}

}
