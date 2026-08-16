<?php

namespace App\Models;

use App\Enums\Status;
use App\Enums\YesNo;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use UserStamps, SoftDeletes; 
    protected $table = 'languages';
    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
        'is_default' => YesNo::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
}
