<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectGallery extends Model
{
    protected $guarded = ['id'];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
