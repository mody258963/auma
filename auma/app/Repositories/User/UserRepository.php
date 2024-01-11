<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface AudioRepository.
 *
 * @package namespace App\Repositories\Audio;
 */
interface UserRepository extends BaseRepository
{
    public function uplodeimage($request);
    public function updateimage($data, $user);

    
}
