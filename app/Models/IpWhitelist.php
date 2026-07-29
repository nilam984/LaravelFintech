<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpWhitelist extends Model
{
    protected $fillable = ['user_id', 'service_id', 'ip', 'is_deleted'];

    public function service()
    {
        return $this->belongsTo(GlobalService::class, 'service_id');
    }
}
