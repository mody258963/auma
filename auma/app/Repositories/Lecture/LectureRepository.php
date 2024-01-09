<?php

namespace App\Repositories;

use App\Models\Lecture;

class LectureRepository
{
    public function getAll()
    {
        return Lecture::all();
    }

    public function getById($id)
    {
        return Lecture::findOrFail($id);
    }

    public function create(array $data)
    {
        return Lecture::create($data);
    }

    public function update($id, array $data)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->update($data);
        return $lecture;
    }

    public function delete($id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->delete();
    }
}
