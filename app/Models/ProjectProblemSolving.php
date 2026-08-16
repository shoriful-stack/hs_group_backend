<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectProblemSolving extends Model
{
    protected $guarded = ['id'];
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
