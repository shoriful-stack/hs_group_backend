<?php

namespace App\Models;

use App\Enums\Status;
use App\Services\LayoutDataService;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
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
        return $this->belongsTo(ProductCategory::class);
    }
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class);
    }
    public function applications()
    {
        return $this->hasMany(ProductApplication::class);
    }
    public function overviews()
    {
        return $this->hasMany(ProductOverview::class);
    }
    public function features()
    {
        return $this->hasMany(ProductFeature::class);
    }
    public function documents()
    {
        return $this->hasMany(ProductDocument::class);
    }
    protected static function booted()
    {
        static::saved(function ($product) {
            static::clearProductCache($product);
        });

        static::deleted(function ($product) {
            static::clearProductCache($product);
        });
    }
    protected static function clearProductCache($product)
    {
        if ($product->slug) {
            Cache::forget("product_detail_{$product->slug}");
        }

        if(!Cache::has('products_cache_version')){
            Cache::forever('products_cache_version', 1);
        } else{
            Cache::increment('products_cache_version');
        }

        LayoutDataService::forgetCache();
    }
}
