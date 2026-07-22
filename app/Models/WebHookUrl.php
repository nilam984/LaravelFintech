<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebHookUrl extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'webhook_url',
        'status',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service(){
        return $this->belongsTo(GlobalService::class, 'service_id');
    }


}
