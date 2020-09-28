<?php


namespace App\ZenSolutions\Services\Specializations\HistoryPayment;


use Carbon\Carbon;

final class ProcessPayment
{
    public static function process(int $clientId,int $month) : Carbon{
        $payment = app()->make('App\ZenSolutions\Services\HistoryPaymentService');
        $payment->buildInsert(['client_id'=>$clientId,'date_payment'=>Carbon::now()->setMonth($month)]);
        return DefineNextDueDate::returnNextDue($month);
    }
}
