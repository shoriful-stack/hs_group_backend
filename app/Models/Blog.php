<?php

namespace App\Models;

use App\Enums\BlogStatus;
use App\Models\Scopes\BranchScope;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Blog extends Model {
    use UserStamps, HasBranchScope, SoftDeletes, HasSlug;
    protected $table = 'blogs';
    protected $guarded = ['id'];
    protected $casts = [
        'status'       => BlogStatus::class,
        'featured'     => 'boolean',
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()
            ->generateSlugsFrom( 'title' )
            ->saveSlugsTo( 'slug' )
            ->slugsShouldBeNoLongerThan( 255 );
    }

    public function scopePublished( $query ) {
        return $query->where( 'status', BlogStatus::PUBLISHED );
    }

    public function category() {
        return $this->belongsTo( BlogCategory::class, 'category_id' );
    }

    public function author() {
        return $this->belongsTo( BlogAuthor::class, 'author_id' );
    }

    public function language() {
        return $this->belongsTo( Language::class );
    }

    public function tags() {
        return $this->belongsToMany( Tag::class, 'blog_tags', 'blog_id', 'tag_id' )
            ->withoutGlobalScope( BranchScope::class )
            ->whereNull( 'tags.deleted_at' );
    }
    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            if ( Auth::check() ) {
                $model->branch_id = Auth::user()->branch_id;
            }
        } );
    }
}
