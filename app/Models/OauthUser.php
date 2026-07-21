<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OauthUser extends Model
{
    protected $table = 'oauth_users';
    
    protected $fillable = [
        'user_id',
        'service_id',
        'client_id',
        'client_secret',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(GlobalService::class, 'service_id');
    }
}
