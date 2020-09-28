<?php


namespace App\ZenSolutions\Repositories;


use App\ZenSolutions\Models\Client;

class ClientRepository extends EloquentRepository
{
    public function __construct(Client $model)
    {
        parent::__construct($model);
    }
}
