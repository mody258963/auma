<?php

namespace App\Repositories\User\Elqouent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\User\UserRepository;
use App\Entities\User\User;
use Illuminate\Support\Facades\Cache;

use App\Repositories\EloquentBaseRepository;


/**
 * Class AudioRepositoryEloquent.
 *
 * @package namespace App\Repositories\Audio;
 */
class UserRepositoryEloquent extends EloquentBaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function uplodeimage($data)
    {
        if($data['image']){

            $path =  $data['image']->store('public/audios'); // here i stored in the public in storge
            $path = str_replace('public','storage',$path);
            $data['image'] = $path;

            }
            return $this->create($data);
    }

    public function updateimage($data,  $user) {

        if($data['image']){
            // $file = $data['file_path'];
              $path = $data['image']->store('public/audios');
              $path = str_replace('public','storage',$path);
              $data['image'] = $path;

         }
     return $this->update($user,$data);


}


}
