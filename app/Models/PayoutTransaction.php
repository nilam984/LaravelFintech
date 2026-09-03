<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayoutTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'beneficiary_name',
        'beneficiary_mobile',
        'beneficiary_email',
        'bank_name',
        'account_number',
        'ifsc_code',
        'client_ref_id',
        'contact_id',
        'gateway_transaction_id',
        'bank_reference',
        'utr',
        'batch_id',
        'amount',
        'fee',
        'tax',
        'final_amount',
        'mode',
        'purpose',
        'narration',
        'status',
        'status_code',
        'status_response',
        'callback_received',
        'gateway_type',
        'request_payload',
        'response_payload',
        'callback_payload',
        'failed_at',
        'failed_status',
        'failed_status_code',
        'failed_message',
        'cancellation_reason',
        'ip',
        'user_agent',
        'remarks',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'tax' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'callback_received' => 'boolean',
        'request_payload' => 'array',
        'response_payload' => 'array',
        'callback_payload' => 'array',
        'failed_at' => 'datetime',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function bussiness_info()
    {
        return $this->belongsTo(BussinessInfo::class, 'user_id', 'user_id');
    }
}