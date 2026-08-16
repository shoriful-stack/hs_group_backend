<?php

namespace App\Models;

use App\Enums\PageStatus;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use UserStamps, HasBranchScope, SoftDeletes, HasSlug; 
    
    protected $guarded = ['id'];
    protected $table = 'pages';
    protected $casts = [
        'status' => PageStatus::class,
    ];

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom( 'title' )
            ->saveSlugsTo( 'slug' )
            ->slugsShouldBeNoLongerThan( 50 );
    }

    public function scopeActive( $query ) {
        return $query->where( 'status', PageStatus::PUBLISHED );
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
