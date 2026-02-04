<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public const TYPE_ADMIN = 'admin';
    public const TYPE_MENTOR = 'mentor';
    public const TYPE_MENTEE = 'mentee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'user_type',
        'password',
        'marital_status',
        'occupation',
        'occupation_category',
        'church',
        'country',
        'state',
        'city',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function isAdmin(): bool
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    public function isMentor(): bool
    {
        return $this->user_type === self::TYPE_MENTOR;
    }

    public function isMentee(): bool
    {
        return $this->user_type === self::TYPE_MENTEE;
    }

    /**
     * Get the dashboard route name for this user type.
     */
    public function dashboardRoute(): string
    {
        return match ($this->user_type) {
            self::TYPE_ADMIN => 'admin.index',
            self::TYPE_MENTOR => 'mentor.index',
            self::TYPE_MENTEE => 'mentee.index',
            default => 'admin.index',
        };
    }

    public function cohorts(): BelongsToMany
    {
        return $this->belongsToMany(Cohort::class, 'cohort_user')
            ->withTimestamps();
    }

    public function cohort(): ?Cohort
    {
        return $this->cohorts()->first();
    }

    public function mentoredCohorts(): HasMany
    {
        return $this->hasMany(Cohort::class, 'mentor_id');
    }
}
