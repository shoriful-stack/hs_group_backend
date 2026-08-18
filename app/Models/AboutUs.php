<?php

namespace App\Models;

use App\Enums\AboutUsType;
use App\Enums\Status;
use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AboutUs extends Model {
    use UserStamps, SoftDeletes, HasBranchScope;

    protected $guarded = [
        'id',
    ];
    protected $table = 'about_us';
    protected $casts = [
        'status' => Status::class,
        'type'   => AboutUsType::class,
        'images' => 'array',
    ];
    public function language(){
        return $this->belongsTo(Language::class);
    }
    public function scopeActive( $query ) {
        return $query->where( 'status', Status::ACTIVE );
    }

    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            $model->branch_id = Auth::user()->branch_id;
        } );
    }
}
