<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceScope extends Model
{
    protected $guarded = ['id'];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
