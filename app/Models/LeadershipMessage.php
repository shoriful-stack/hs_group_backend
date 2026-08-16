<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;

class LeadershipMessage extends Model
{
    use UserStamps;
    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
}
