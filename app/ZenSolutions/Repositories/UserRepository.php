<?php

namespace App\ZenSolutions\Repositories;


use App\ZenSolutions\Models\User;

/**
 * Class UserRepository
 *
 * @package App\ZenSolutions\Repositories
 * @version 1.0.0
 */
class UserRepository extends EloquentRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
