<?php

namespace App\Models;

use App\Enums\Status;
use App\Services\LayoutDataService;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
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
        return $this->belongsTo(ServiceCategory::class);
    }
    public function highlights()
    {
        return $this->hasMany(ServiceHighlight::class);
    }

    public function benefits()
    {
        return $this->hasMany(ServiceBenefit::class);
    }

    public function capabilities()
    {
        return $this->hasMany(ServiceCapability::class);
    }

    public function scopes()
    {
        return $this->hasMany(ServiceScope::class)->orderBy('step_number');
    }

    public function processSteps()
    {
        return $this->hasMany(ServiceProcess::class)->orderBy('serial_no');
    }

    public function equipments()
    {
        return $this->hasMany(ServiceEquipment::class);
    }
    public function ctas()
    {
        return $this->morphMany(Cta::class, 'ctaable');
    }
    protected static function booted()
    {
        static::saved(function ($service) {
            static::clearServiceCache($service);
        });

        static::deleted(function ($service) {
            static::clearServiceCache($service);
        });
    }
    protected static function clearServiceCache($service)
    {
        if ($service->slug) {
            Cache::forget("service_detail_{$service->slug}");
        }

        if (!Cache::has('services_cache_version')) {
            Cache::forever('services_cache_version', 1);
        } else {
            Cache::increment('services_cache_version');
        }

        LayoutDataService::forgetCache();
    }
}
