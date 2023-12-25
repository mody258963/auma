<?php

namespace App\Repositories\Audio;

use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AudioRepository.
 *
 * @package namespace App\Repositories\Audio;
 */
interface AudioRepository extends BaseRepository
{
    public function uplodefile($request);
}       
