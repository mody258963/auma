<?php

namespace App\Repositories\Audio\Elqouent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Audio\AudioRepository;
use App\Entities\Audio\Audio;
use Illuminate\Support\Facades\Cache;

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

        $path =  $data['file_path']->store('public/audios'); // here i stored in the public in storge
        $path = str_replace('public','storage',$path);
        $data['file_path'] = $path;


            // $path =  $data['file_path']->store('audios','public'); // here i stored in the public in storge
            // $path = 'storage/'.$path;
            // $data['file_path'] = $path;
        }
        return $this->create($data);
    }
    
    public function updatefile($data,  $audio) {
        
       // dd($data);
        if($data['file_path']){
          // $file = $data['file_path'];
            $path = $data['file_path']->store('public/audios'); 
            $path = str_replace('public','storage',$path);
            $data['file_path'] = $path;
            
       }
   return $this->update($audio,$data); 

}

}
