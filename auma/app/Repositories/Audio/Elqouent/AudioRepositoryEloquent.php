<?php

namespace App\Repositories\Audio;

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
    public function uplodefile($request)
    {
        $file = $request->file('file_path'); 
        $audio = $request->all();
        $path =  $file->store('public/audios'); // here i stored in the public in storge
        $path = str_replace('public','storage',$path);
        $audio->file_path = $path;
        return $this->create($audio);
    }

    

    
    
}
