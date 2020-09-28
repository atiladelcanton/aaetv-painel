<?php


namespace App\ZenSolutions\Services;


use App\ZenSolutions\Contracts\ServiceContract;
use App\ZenSolutions\Models\Client;
use App\ZenSolutions\Services\Specializations\Client\ClientNotFound;
use App\ZenSolutions\Services\Specializations\HistoryPayment\DefineNextDueDate;
use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService implements ServiceContract
{
    private $repository;
    private $historyRepository;

    public function __construct()
    {
        $this->repository = app()->make('App\ZenSolutions\Repositories\ClientRepository');
        $this->historyRepository = app()->make('App\ZenSolutions\Services\HistoryPaymentService');
    }

    public function renderList(string $column = 'id', string $orderColumn = 'DESC'): LengthAwarePaginator
    {
        return $this->repository->getAll($column, $orderColumn);
    }

    /**
     * @param int $id
     *
     * @return Client
     * @throws Exception
     */
    public function renderEdit(int $id): Client
    {
        ClientNotFound::found($id);
        return $this->repository->getById($id);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return mixed
     * @throws Exception
     */
    public function buildUpdate(int $id, array $data)
    {
        ClientNotFound::found($id);
        $this->repository->update($id, $data);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function buildInsert(array $data): Client
    {
        $data['next_due_date'] = DefineNextDueDate::returnNextDue();
        $client = $this->repository->create($data);
        $this->historyRepository->buildInsert(['client_id' => $client->id, 'date_payment' => Carbon::now()]);
        return $client;
    }
    public  function updateNextDueDate(int $clientId,Carbon $dueDate) : bool{
        ClientNotFound::found($clientId);
        return $this->repository->update($clientId,['next_due_date'=>$dueDate]);
    }
    /**
     * @param int $id
     *
     * @throws Exception
     */
    public function buildDelete(int $id): void
    {
        ClientNotFound::found($id);
        $this->repository->delete($id);
    }
}
