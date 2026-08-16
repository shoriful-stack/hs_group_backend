<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEquipment extends Model
{
    protected $guarded = ['id'];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function category()
    {
        return $this->belongsTo(ProjectEquipmentCategory::class, 'project_equipment_category_id');
    }
}
