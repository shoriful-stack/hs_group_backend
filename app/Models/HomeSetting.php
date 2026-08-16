<?php

namespace App\Models;

use App\Traits\HasBranchScope;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class HomeSetting extends Model {
    use UserStamps, HasBranchScope;

    protected $guarded = ['id'];
    protected $table = 'home_settings';

    public function sections() {
        return $this->hasMany( HomeSection::class, 'branch_id', 'branch_id' );
    }
    protected static function boot() {
        parent::boot();
        static::creating( function ( $model ) {
            $model->branch_id = Auth::user()->branch_id;
        } );
    }
}
