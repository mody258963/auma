<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    public  $table = 'teacher';
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'is_blocked',
        'is_accepted',
        'link',
    ];

    public function course (){
        return  $this->hasMany(Course::class);
    }

}
