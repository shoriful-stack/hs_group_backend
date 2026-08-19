<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class NewsEvent extends Model
{
    use UserStamps, HasBranchScope, SoftDeletes, HasSlug;

    protected $table = 'news_events';
    protected $guarded = ['id'];
    protected $casts = [
        'status'     => Status::class,
        'event_date' => 'date',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function isUpcoming(): bool
    {
        return $this->event_date && $this->event_date->gte(now()->startOfDay());
    }

    public function timing(): string
    {
        return $this->isUpcoming() ? 'upcoming' : 'past';
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->branch_id = Auth::user()->branch_id;
            }
            if (empty($model->language_id)) {
                $model->language_id = 1;
            }
        });
    }
}
