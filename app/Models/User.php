<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cohort;
use App\Models\CohortAttendance;
use App\Models\Event;
use App\Models\EventRegistration;
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
    public const TYPE_COORDINATOR = 'coordinator';
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

    public function isCoordinator(): bool
    {
        return $this->user_type === self::TYPE_COORDINATOR;
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
            self::TYPE_COORDINATOR => 'coordinator.index',
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

    public function coordinatedCohorts(): HasMany
    {
        return $this->hasMany(Cohort::class, 'coordinator_id');
    }

    public function cohortAttendances(): HasMany
    {
        return $this->hasMany(CohortAttendance::class);
    }

    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function createdEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function moduleReviews(): HasMany
    {
        return $this->hasMany(ModuleReview::class);
    }

    public function menteeSemesterProjects(): HasMany
    {
        return $this->hasMany(MenteeSemesterProject::class);
    }

    public function userSemesterPoints(): HasMany
    {
        return $this->hasMany(UserSemesterPoints::class);
    }
}
