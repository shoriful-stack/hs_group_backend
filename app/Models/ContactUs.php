<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class ContactUs extends Model {
    use UserStamps, HasBranchScope, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'contact_us';

    public function language() {
        return $this->belongsTo( Language::class );
    }
    public function branch() {
        return $this->belongsTo( Branch::class );
    }
    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            $model->branch_id = Auth::user()->branch_id;
        } );
    }
}
