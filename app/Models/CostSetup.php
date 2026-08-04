<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CostSetup extends Model
{
    protected $table = 'cost_setups';

    protected $fillable = [
        'service_id',
        'cost'
    ];

    public function service(){
        return $this->belongsTo(GlobalService::class, 'service_id', 'id');
    }
}
