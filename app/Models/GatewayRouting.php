<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GatewayRouting extends Model
{
    protected $fillable = ['payment_gateway_id', 'gateway_type', 'updated_by'];

    public function gatewayName()
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id', 'id');
    }
}
