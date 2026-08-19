<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CareerJob extends Model
{
    use UserStamps, SoftDeletes, HasSlug;

    protected $table = 'career_jobs';
    protected $guarded = ['id'];
    protected $casts = [
        'status'                      => Status::class,
        'posted_at'                   => 'date',
        'application_deadline'        => 'date',
        'featured'                    => 'boolean',
        'vacancy'                     => 'integer',
        'educational_qualifications'  => 'array',
        'experience_details'          => 'array',
        'responsibilities'            => 'array',
        'requirements'                => 'array',
        'nice_to_have'                => 'array',
        'benefits'                    => 'array',
        'contact_phones'              => 'array',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(80);
    }

    public function scopeActive($query)
    {
        return $query->where('status', Status::ACTIVE);
    }

    public function scopePublished($query)
    {
        return $query->active()->orderByDesc('featured')->orderByDesc('posted_at')->orderBy('serial_no');
    }
}
