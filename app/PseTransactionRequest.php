<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PseTransactionRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transactionID', 'sessionID', 'returnCode', 'trazabilityCode', 'transactionCycle',
        'bankCurrency', 'bankFactor', 'bankURL', 'responseCode', 'responseReasonCode',
        'responseReasonText',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    protected $table = "pse_transaction_requests";
}
