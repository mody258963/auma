<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';
    protected $fillable = [
        'title',
        'description',
        'category_id',
        'teacher_id',
        'book',
        'image'


    ];
    public function users()
{
  return $this->belongsToMany(User::class,'user_course');
}
public function user()
{
  return $this->belongsToMany(User::class,'favorites');
}




public function teacher()
{
  return $this->belongsTo(Teacher::class);
}
public function category(){
  return $this -> belongsTo(Category::class);
  }

public function lecture()
{
  return $this->hasMany(Lecture::class);
}


}
