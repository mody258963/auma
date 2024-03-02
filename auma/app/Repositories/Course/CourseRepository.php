<?php

namespace App\Repositories\Course;

use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AudioRepository.
 *
 * @package namespace App\Repositories\Course;
 */
interface CourseRepository extends BaseRepository
{

    public function uplodeimage($request);
}
