<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',

    ];
    public function user()
{
  return $this->belongsTo(User::class);
}
public function Favorites()
{
  return $this->hasMany(Favorites::class);
}
public function audio()
{
  return $this->hasMany(Audio::class);
}


}
