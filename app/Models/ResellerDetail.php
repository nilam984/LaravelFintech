<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResellerDetail extends Model
{
    protected $fillable = ['reseller_id', 'aadhar_no', 'aadhar_front_image', 'aadhar_back_image', 'pan_no', 'pan_image', 'updated_by'];

    public function reseller()
    {
        return $this->belongsTo(User::class, 'reseller_id', 'id');
    }
}
