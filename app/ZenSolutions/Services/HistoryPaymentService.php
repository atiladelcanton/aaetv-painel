<?php


namespace App\ZenSolutions\Services;


use App\ZenSolutions\Contracts\ServiceContract;

class HistoryPaymentService implements ServiceContract
{
    private $repository;

    public function __construct()
    {
        $this->repository = app()->make('App\ZenSolutions\Repositories\HistoryPaymentRepository');
    }

    /**
     * @inheritDoc
     */
    public function renderList(string $column = 'id', string $orderColumn = 'DESC')
    {
        return $this->repository->getAll($column, $orderColumn);
    }

    /**
     * @inheritDoc
     */
    public function renderEdit(int $id)
    {
        return $this->repository->getById($id);
    }

    /**
     * @inheritDoc
     */
    public function buildUpdate(int $id, array $data)
    {
        $this->repository->update($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function buildInsert(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @inheritDoc
     */
    public function buildDelete(int $id): void
    {
        $this->repository->delete($id);
    }
}
