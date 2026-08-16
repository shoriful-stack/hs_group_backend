<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class HomeSection extends Model {
    use UserStamps, HasBranchScope, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'home_sections';
    public function page() {
        return $this->belongsTo( Page::class );
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->branch_id = Auth::user()->branch_id;
        });
    }
}
