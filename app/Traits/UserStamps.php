<?php

namespace App\Traits;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait UserStamps
{
    public static function bootUserStamps()
    {
        static::creating(function ($model) {
            if (
                Auth::check() &&
                Schema::hasColumn($model->getTable(), 'branch_id') &&
                $model->getTable() !== 'users' &&
                empty($model->branch_id)
            ) {
                $model->branch_id = Auth::user()->branch_id;
            }

            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = $model->created_by ?? Auth::id();
            }
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = $model->updated_by ?? Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = Auth::user()->id;
            }
        });

        static::deleting(function ($model) {
            if ($userId = Auth::id()) {
                if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                    $model->deleted_by = $userId;
                }
                if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                    $model->updated_by = Auth::user()->id;
                }

                if (method_exists($model, 'runSoftDelete')) {
                    $model->save();
                }
            }
        });
    }

    // Relationships

    public function branch()
    {
        if (Schema::hasColumn($this->getTable(), 'branch_id')) {
            return $this->belongsTo(Branch::class, 'branch_id');
        }
        return null;
    }

    public function createdBy()
    {
        if (Schema::hasColumn($this->getTable(), 'created_by')) {
            return $this->belongsTo(User::class, 'created_by');
        }
        return null;
    }

    public function updatedBy()
    {
        if (Schema::hasColumn($this->getTable(), 'updated_by')) {
            return $this->belongsTo(User::class, 'updated_by');
        }
    }

    public function deletedBy()
    {
        if (Schema::hasColumn($this->getTable(), 'deleted_by')) {
            return $this->belongsTo(User::class, 'deleted_by');
        }
    }
}
