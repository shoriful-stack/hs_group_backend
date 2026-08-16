<?php

namespace App\Traits;

use App\Models\Scopes\BranchScope;

trait HasBranchScope
{
    protected static function bootHasBranchScope(): void
    {
        static::addGlobalScope(new BranchScope);
    }
}
