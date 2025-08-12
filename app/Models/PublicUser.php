<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class PublicUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'public_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'ic_number',
        'phone',
        'address',
        'postcode',
        'city',
        'state',
        'date_of_birth',
        'gender',
        'occupation',
        'income_bracket',
        'household_size',
        'preferred_language',
        'email_verified_at',
        'phone_verified_at',
        'profile_completed',
        'consent_marketing',
        'consent_data_sharing',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'profile_completed' => 'boolean',
        'consent_marketing' => 'boolean',
        'consent_data_sharing' => 'boolean',
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function initiatives()
    {
        return $this->hasMany(InitiativeSubmission::class);
    }

    public function contributionRequests()
    {
        return $this->hasMany(ContributionRequest::class);
    }

    public function notifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->postcode . ' ' . $this->city . ', ' . $this->state;
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    public function getProfileCompletionPercentageAttribute()
    {
        $requiredFields = ['name', 'email', 'ic_number', 'phone', 'address', 'postcode', 'city', 'state'];
        $completed = 0;
        
        foreach ($requiredFields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        return round(($completed / count($requiredFields)) * 100);
    }
}