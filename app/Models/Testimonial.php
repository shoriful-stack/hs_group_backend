<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use UserStamps, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'testimonials';
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
}
