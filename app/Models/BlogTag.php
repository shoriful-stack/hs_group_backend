<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class BlogTag extends Model {
    use UserStamps, HasBranchScope, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'blog_tags';
    protected $casts = [
        'status' => Status::class,
    ];

    public function scopeActive( $query ) {
        return $query->where( 'status', Status::ACTIVE );
    }

    public function blogs() {
        return $this->hasMany( Blog::class, 'blog_id' );
    }

    public function language() {
        return $this->belongsTo( Language::class );
    }

    public function tag() {
        return $this->belongsTo( Tag::class );
    }
    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            $model->branch_id = Auth::user()->branch_id;
        } );
    }
}
