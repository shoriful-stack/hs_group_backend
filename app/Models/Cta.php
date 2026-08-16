<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cta extends Model
{
    protected $guarded = ['id'];
    public function ctaable()
    {
        return $this->morphTo();
    }
}
