<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MajooEdcTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'edc_type', 'proc_date', 'mid', 'ob', 'gb', 'seq', 'type', 'trx_date', 'auth', 'card_no',
        'amount', 'tid', 'jenis_trx', 'ptr', 'rate', 'disc_amount', 'air_fare', 'plan', 'ss_amount',
        'ss_fee_type', 'flag', 'nett_amount', 'merchant_account', 'merchant_name', 'fingerprint_hash', 'user_id'
    ];

    protected $casts = [
        'proc_date' => 'date',
        'trx_date' => 'date',
        'amount' => 'decimal:2',
        'rate' => 'decimal:4',
        'disc_amount' => 'decimal:2',
        'air_fare' => 'decimal:2',
        'ss_amount' => 'decimal:2',
        'nett_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
