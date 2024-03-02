<?php

namespace App\Repositories\Course\Elqouent;

require './vendor/autoload.php';
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Course\CourseRepository;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Encoders\AutoEncoder;
use Intervention\Image\ImageManager;
use Intervention\image\Drivers\Gd\Driver;
use App\Repositories\EloquentBaseRepository;


/**
 * Class AudioRepositoryEloquent.
 *
 * @package namespace App\Repositories\Audio;
 */
class CourseRepositoryEloquent extends EloquentBaseRepository implements CourseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

     
     public function uplodeimage($data)
    {
        $manager = new ImageManager(Driver::class);
        if($data['image']){
            $image = $data->file('image');
            $encoded = $image->encode(new AutoEncoder(quality: 50)); 
       
            $path = $encoded->storePublicly('public/images');
            $data['image']= "https://uamh-laravel.s3.amazonaws.com/$path";
            



            }
            return $this->create($data);
    }

    
}
