<?php


namespace App\ZenSolutions\Repositories;


use App\ZenSolutions\Models\Role;

class RoleRepository extends EloquentRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
