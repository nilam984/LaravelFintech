<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BussinessInfo extends Model
{
    protected $table = 'business_infos';

    protected $fillable = [
        'user_id',
        'business_name',
        'business_email',
        'business_phone',
        'pan',
        'pan_image',
        'gst',
        'business_type',
        'business_category',
        'website_url',
        'owner_aadhar',
        'owner_aadhar_image_front',
        'owner_aadhar_image_back',
        'owner_pan',
        'owner_pan_image',
        'city',
        'state',
        'pin_code',
        'full_address'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
