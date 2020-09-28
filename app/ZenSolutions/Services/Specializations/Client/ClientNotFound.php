<?php


namespace App\ZenSolutions\Services\Specializations\Client;


use App\ZenSolutions\Models\Client;
use Exception;

final class ClientNotFound
{
    /**
     * @param int $clientId
     *
     * @throws Exception
     */
    public static function found(int $clientId)
    {
        $clientRepository = app()->make('App\ZenSolutions\Repositories\ClientRepository');
        $client = $clientRepository->getById($clientId);
        if (is_null($client)) {
            throw new Exception('Cliente não encontrado', 404);
        }
    }
}
