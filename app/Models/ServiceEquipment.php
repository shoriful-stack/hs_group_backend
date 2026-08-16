<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceEquipment extends Model
{
    protected $guarded = ['id'];
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
    public function category()
    {
        return $this->belongsTo(ServiceEquipmentCategory::class, 'service_equipment_category_id');
    }
}
