<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InitiativeApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'initiative_id',
        'public_user_id',
        'status',
        'application_data',
        'admin_notes',
        'user_notes',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
        'approved_at',
        'rejected_at',
        'rejection_reason',
        'priority_score',
        'is_urgent',
        'contact_preference',
        'additional_documents',
    ];

    protected $casts = [
        'application_data' => 'array',
        'additional_documents' => 'array',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_urgent' => 'boolean',
        'priority_score' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'submitted_at',
        'reviewed_at',
        'approved_at',
        'rejected_at',
    ];

    // Relationships
    public function initiative(): BelongsTo
    {
        return $this->belongsTo(Initiative::class);
    }

    public function publicUser(): BelongsTo
    {
        return $this->belongsTo(PublicUser::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'mediable_id')->where('mediable_type', InitiativeApplication::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Accessors
    public function getApplicationNumberAttribute(): string
    {
        return 'APP-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'under_review' => 'bg-blue-100 text-blue-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'on_hold' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getProcessingTimeAttribute(): int
    {
        if (!$this->submitted_at) {
            return 0;
        }

        $endDate = $this->reviewed_at ?? now();
        return $this->submitted_at->diffInDays($endDate);
    }

    public function getIsOverdueAttribute(): bool
    {
        // Consider overdue if pending for more than 7 days
        return $this->status === 'pending' && 
               $this->submitted_at && 
               $this->submitted_at->diffInDays(now()) > 7;
    }

    public function getPriorityLevelAttribute(): string
    {
        if ($this->is_urgent) {
            return 'Urgent';
        }

        return match($this->priority_score) {
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            4 => 'Very High',
            5 => 'Critical',
            default => 'Medium',
        };
    }

    // Methods
    public function submit(): void
    {
        $this->update([
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Increment initiative application count
        $this->initiative->incrementApplications();
    }

    public function approve(int $reviewerId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'approved_at' => now(),
            'admin_notes' => $notes,
        ]);
    }

    public function reject(int $reviewerId, string $reason, ?string $notes = null): void
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'rejected_at' => now(),
            'rejection_reason' => $reason,
            'admin_notes' => $notes,
        ]);

        // Decrement initiative application count
        $this->initiative->decrementApplications();
    }

    public function putUnderReview(int $reviewerId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'under_review',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'admin_notes' => $notes,
        ]);
    }

    public function putOnHold(int $reviewerId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'on_hold',
            'reviewed_at' => now(),
            'reviewed_by' => $reviewerId,
            'admin_notes' => $notes,
        ]);
    }

    public function canBeApproved(): bool
    {
        return in_array($this->status, ['pending', 'under_review', 'on_hold']);
    }

    public function canBeRejected(): bool
    {
        return in_array($this->status, ['pending', 'under_review', 'on_hold']);
    }

    public function getApplicationDataValue(string $key, $default = null)
    {
        return data_get($this->application_data, $key, $default);
    }

    public function setApplicationDataValue(string $key, $value): void
    {
        $data = $this->application_data ?? [];
        data_set($data, $key, $value);
        $this->update(['application_data' => $data]);
    }
}
