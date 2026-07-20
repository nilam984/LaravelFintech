<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeRules extends Model
{
    protected $fillable = ['scheme_id', 'service_id', 'product_id', 'fee_type', 'start_value', 'end_value', 'fee', 'min_fee', 'max_fee', 'status', 'updated_by'];
}
