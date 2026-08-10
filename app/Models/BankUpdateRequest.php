<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankUpdateRequest extends Model
{
    protected $fillable = ['user_id', 'request_remark', 'reject_remark', 'status', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
