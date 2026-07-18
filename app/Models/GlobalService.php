<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GlobalService extends Model
{
    protected $fillable = [
        'service_name',
        'status',
        'is_api_enabled'
    ];

    public function serviceRequest()
    {
        $userId = Auth::user()->id;
        return $this->hasOne(ServiceRequest::class, 'service_id')->where('user_id', $userId);
    }
}
