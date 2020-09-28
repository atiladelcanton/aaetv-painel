<?php


namespace App\ZenSolutions\Services\Specializations\HistoryPayment;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

final class ReturnPaymentsClient
{
    public static function returnPayments(Collection $payments): array
    {
        $paymentsClient = [
            ['month' => '01'],
            ['month' => '02'],
            ['month' => '03'],
            ['month' => '04'],
            ['month' => '05'],
            ['month' => '06'],
            ['month' => '07'],
            ['month' => '08'],
            ['month' => '09'],
            ['month' => '10'],
            ['month' => '11'],
            ['month' => '12'],
        ];

        foreach ($payments as $payment) {
            foreach ($paymentsClient as $key => $pay) {
                if (Carbon::parse($payment->date_payment)->format('m') == $pay['month']) {

                        $paymentsClient[$key]['style'] = 'background: #00800082;color: #FFF;text-align: center;';
                        $paymentsClient[$key]['icon'] = 'fa fa-check';

                } elseif (Carbon::parse($payment->date_payment)->format('m') < $pay['month']) {
                    if (!isset($paymentsClient[$key]['icon'])) {
                        $paymentsClient[$key]['style'] = 'background: #80808057;color: #FFF;text-align: center;';
                        $paymentsClient[$key]['icon'] = 'fa fa-exclamation';
                    }
                } else {
                    if (!isset($paymentsClient[$key]['icon'])) {
                        $paymentsClient[$key]['style'] = 'background: #808080b8;color: #FFF;text-align: center;';
                        $paymentsClient[$key]['icon'] = 'fa fa-ban';
                    }
                }
            }
        }

        return $paymentsClient;
    }
}
