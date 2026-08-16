<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Status;
use App\Traits\UserStamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, UserStamps,HasApiTokens;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'branch_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected $casts = [
        'is_active' => Status::class,
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            // $model->branch_id = Auth::user()->branch_id;
            if (!$model->branch_id && Auth::check()) {
                $model->branch_id = Auth::user()->branch_id;
            }
        });
    }
}
