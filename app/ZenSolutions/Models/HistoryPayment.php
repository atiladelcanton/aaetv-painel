<?php


namespace App\ZenSolutions\Models;


use Illuminate\Database\Eloquent\Model;

class HistoryPayment extends Model
{
    protected $table = 'history_payment';
    protected $fillable = [
        'client_id',
        'date_payment',
        'path_voucher_payment'
    ];
}
