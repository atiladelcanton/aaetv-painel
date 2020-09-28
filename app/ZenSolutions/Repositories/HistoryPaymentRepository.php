<?php


namespace App\ZenSolutions\Repositories;


use App\ZenSolutions\Models\HistoryPayment;

class HistoryPaymentRepository extends EloquentRepository
{
    public function __construct(HistoryPayment $model)
    {
        parent::__construct($model);
    }
}
