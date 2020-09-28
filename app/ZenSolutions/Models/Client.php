<?php


namespace App\ZenSolutions\Models;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'cod',
        'next_due_date',
        'method_payment',
        'app',
        'monthly_payment',
        'number_points',
        'code_ssiptv',
        'code_duplex',
        'email_smart_up',
        'observations',
        'responsible'
    ];
    protected $with = ['historyPayments','responsibleClient'];

    public function historyPayments()
    {
        return $this->hasMany(HistoryPayment::class, 'client_id', 'id');
    }

    public function responsibleClient()
    {
        return $this->belongsTo(User::class,'responsible');
    }
}
