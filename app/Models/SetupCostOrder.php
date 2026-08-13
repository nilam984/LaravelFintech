<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupCostOrder extends Model
{
    protected $fillable = [
        'reseller_id',
        'user_id',
        'name',
        'email',
        'mobile',
        'pan_no',
        'pan_image',
        'service_ids',
        'total_amount',
        'status',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'paid_at',
        'failure_reason',
    ];

    protected $casts = [
        'service_ids' => 'array',
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id');
    }
}
