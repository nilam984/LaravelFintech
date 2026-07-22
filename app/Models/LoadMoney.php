<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoadMoney extends Model
{
    protected $fillable = ['user_id', 'amount', 'utr', 'request_id', 'mode', 'pay_receipt', 'status', 'updated_by', 'rejection_remark'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
