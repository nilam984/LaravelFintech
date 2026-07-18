<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'business_info_id',
        'bank_name',
        'account_number',
        'account_holder_name',
        'ifsc_code',
        'branch_name',
        'bank_docs',
    ];
}
