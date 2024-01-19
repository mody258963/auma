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
        'file_path',

    ];

public function lecture()
{
  return $this->belongsTo(Lecture::class);
}


}
