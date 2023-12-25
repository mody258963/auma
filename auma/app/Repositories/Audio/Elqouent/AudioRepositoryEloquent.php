<?php

namespace App\Repositories\Audio\Elqouent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Audio\AudioRepository;
use App\Entities\Audio\Audio;
use App\Repositories\EloquentBaseRepository;
use App\Validators\Audio\AudioValidator;

/**
 * Class AudioRepositoryEloquent.
 *
 * @package namespace App\Repositories\Audio;
 */
class AudioRepositoryEloquent extends EloquentBaseRepository implements AudioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function uplodefile($data)
    {
        if($data['file_path']){
            $path =  $data['file_path']->store('audios','public'); // here i stored in the public in storge
            $path = 'storage/'.$path;
            $data['file_path']= $path;
        }
        return $this->create($data);
    }





}
