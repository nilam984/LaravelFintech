<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'status',
        'updated_by'
    ];

    /**
     * Relationship: A service request belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship: A service request belongs to a service
     */
    public function service()
    {
        return $this->belongsTo(GlobalService::class, 'service_id');
    }
    
}
