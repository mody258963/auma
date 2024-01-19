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
        'category_id'

    ];
    public function users()
{
  return $this->belongsToMany(User::class,'user_course')->withTimestamps();
}
public function user()
{
  return $this->belongsToMany(User::class,'favorites')->withTimestamps();
}




public function teacher()
{
  return $this->belongsTo(Teacher::class)->withTimestamps();
}
public function category(){
  return $this -> belongsTo(Category::class);
  }

public function audio()
{
  return $this->hasMany(Audio::class);
}


}
