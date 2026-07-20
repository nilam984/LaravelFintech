<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    protected $fillable = ['product_name', 'service_id', 'status'];
}
