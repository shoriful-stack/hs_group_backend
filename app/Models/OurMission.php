<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class OurMission extends Model {
    use UserStamps, HasBranchScope, SoftDeletes;
    protected $table = 'our_missions';
    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive( $query ) {
        return $query->where( 'status', Status::ACTIVE );
    }

    public function language() {
        return $this->belongsTo( Language::class );
    }
    public function branch() {
        return $this->belongsTo( Branch::class );
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->branch_id = Auth::user()->branch_id;
        });
    }
}
