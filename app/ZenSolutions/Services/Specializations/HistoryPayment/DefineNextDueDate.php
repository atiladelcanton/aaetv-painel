<?php


namespace App\ZenSolutions\Services\Specializations\HistoryPayment;


use Carbon\Carbon;

final class DefineNextDueDate
{
    public static function returnNextDue(int $month = null): Carbon
    {
        $nextDue = Carbon::now()->addMonth();
        if (!is_null($month)) {
            $nextDue = Carbon::now()->setMonth($month)->addMonth();
        }
        return $nextDue;
    }
}
