<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProjectCategory extends Model
{
    use UserStamps, HasSlug;
    protected $table = 'project_categories';
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

    public function projects()
    {
        return $this->hasMany(Project::class, 'category_id');
    }
}
