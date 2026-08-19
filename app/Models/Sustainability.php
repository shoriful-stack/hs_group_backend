<?php

namespace App\Models;

use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sustainability extends Model
{
    use UserStamps, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'sustainabilities';
}
