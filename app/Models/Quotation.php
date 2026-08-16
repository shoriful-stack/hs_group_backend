<?php

namespace App\Models;

use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use UserStamps;

    protected $guarded = ['id'];
    protected $table = 'quotations';
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
