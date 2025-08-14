<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Initiative extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'category',
        'eligibility_criteria',
        'benefits',
        'requirements',
        'application_deadline',
        'start_date',
        'end_date',
        'max_applications',
        'current_applications',
        'status',
        'is_featured',
        'featured_image',
        'user_id',
        'budget_amount',
        'budget_used',
        'location',
        'contact_person',
        'contact_email',
        'contact_phone',
        'application_form_data',
        'notification_settings',
    ];

    protected $casts = [
        'application_deadline' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_featured' => 'boolean',
        'budget_amount' => 'decimal:2',
        'budget_used' => 'decimal:2',
        'application_form_data' => 'array',
        'notification_settings' => 'array',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'application_deadline',
        'start_date',
        'end_date',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(InitiativeApplication::class);
    }

    public function approvedApplications(): HasMany
    {
        return $this->hasMany(InitiativeApplication::class)->where('status', 'approved');
    }

    public function pendingApplications(): HasMany
    {
        return $this->hasMany(InitiativeApplication::class)->where('status', 'pending');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'mediable_id')->where('mediable_type', Initiative::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('application_deadline', '>', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOpenForApplications($query)
    {
        return $query->where('status', 'active')
                    ->where('application_deadline', '>', now())
                    ->where(function ($q) {
                        $q->whereNull('max_applications')
                          ->orWhere('current_applications', '<', 'max_applications');
                    });
    }

    // Accessors
    public function getFullUrlAttribute(): string
    {
        return url('/initiatives/' . $this->slug);
    }

    public function getExcerptAttribute(): string
    {
        return \Str::limit(strip_tags($this->description), 200);
    }

    public function getApplicationProgressAttribute(): float
    {
        if (!$this->max_applications) {
            return 0;
        }
        
        return round(($this->current_applications / $this->max_applications) * 100, 2);
    }

    public function getBudgetProgressAttribute(): float
    {
        if (!$this->budget_amount) {
            return 0;
        }
        
        return round(($this->budget_used / $this->budget_amount) * 100, 2);
    }

    public function getIsOpenForApplicationsAttribute(): bool
    {
        return $this->status === 'active' 
            && $this->application_deadline > now()
            && ($this->max_applications === null || $this->current_applications < $this->max_applications);
    }

    public function getDaysUntilDeadlineAttribute(): int
    {
        return max(0, now()->diffInDays($this->application_deadline, false));
    }

    // Mutators
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = \Str::slug($value);
    }

    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = $value;
        if (empty($this->slug)) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    // Methods
    public function incrementApplications(): void
    {
        $this->increment('current_applications');
    }

    public function decrementApplications(): void
    {
        $this->decrement('current_applications');
    }

    public function canAcceptApplications(): bool
    {
        return $this->is_open_for_applications;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800',
            'draft' => 'bg-gray-100 text-gray-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
