<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Stat extends Model
{
    use UserStamps, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'stats';
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
}
