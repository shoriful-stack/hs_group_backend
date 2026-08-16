<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class IotSolution extends Model
{
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'status' => Status::class,
        'features' => 'array',
    ];
}
