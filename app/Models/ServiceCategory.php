<?php

namespace App\Models;

use App\Enums\Status;
use App\Services\LayoutDataService;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ServiceCategory extends Model
{
    use UserStamps, HasSlug;
    protected $table = 'service_categories';
    protected $guarded = ['id'];
    protected $casts = [
        'status' => Status::class,
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    protected static function booted()
    {
        static::saved(fn () => LayoutDataService::forgetCache());
        static::deleted(fn () => LayoutDataService::forgetCache());
    }
}
