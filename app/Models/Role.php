<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use UserStamps, SoftDeletes;

    protected $fillable = ['id'];
    protected $table = 'roles';
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

}
