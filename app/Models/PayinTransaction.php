<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayinTransaction extends Model
{
    protected $fillable = ['user_id', 'payer_name', 'payer_mobile', 'payer_email', 'user_order_id', 'payment_reference_id', 'gateway_transaction_id', 'utr', 'amount', 'fee', 'tax', 'final_amount', 'status', 'callback_received', 'is_auto_settlement', 'request_payload', 'response_payload', 'callback_payload', 'remarks', 'updated_by'];
}
