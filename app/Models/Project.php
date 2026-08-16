<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\ProjectReview;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model
{
    use UserStamps, HasSlug;
    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(150);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }
    public function customer()
    {
        return $this->belongsTo(OurCustomer::class, 'our_customer_id');
    }
    public function highlights()
    {
        return $this->hasMany(ProjectHighlight::class);
    }

    public function informations()
    {
        return $this->hasMany(ProjectInformation::class);
    }
    public function scopes()
    {
        return $this->hasMany(ProjectScope::class)->orderBy('step_number');
    }
    public function problemsolvings()
    {
        return $this->hasMany(ProjectProblemSolving::class);
    }
    public function equipments()
    {
        return $this->hasMany(ProjectEquipment::class);
    }
    public function impacts()
    {
        return $this->hasMany(ProjectImpact::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProjectReview::class);
    }

    public function galleries()
    {
        return $this->hasMany(ProjectGallery::class);
    }
    public function ctas()
    {
        return $this->morphMany(Cta::class, 'ctaable');
    }
    protected static function booted()
    {
        static::saved(function ($project) {
            return static::clearProjectCache($project);
        });
        static::deleted(function ($project) {
            return static::clearProjectCache($project);
        });
    }
    protected static function clearProjectCache($project)
    {
        if ($project->slug) {
            Cache::forget("project_detail_{$project->slug}");
        }

        if(!Cache::has('projects_cache_version')){
            Cache::forever('projects_cache_version', 1);
        } else{
            Cache::increment('projects_cache_version');
        }
    }
}
