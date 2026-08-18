<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedgerTransaction extends Model
{
    protected $table = 'ledger_transactions';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'reference_id',
        'account_number',
        'order_id',
        'amount',
        'fee',
        'tax',
        'transaction_type',
        'opening_balance',
        'closing_balance',
        'narration',
        'transaction_date',
        'transaction_identifier',
        'service_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}