<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalService extends Model
{
    protected $fillable = [
        'service_name',
        'status',
        'is_api_enabled'
    ];

    public function service()
    {
        return $this->belongsTo(GlobalService::class, 'service_id');
    }
}
