<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContributionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_user_id',
        'title',
        'description',
        'category',
        'target_amount',
        'current_amount',
        'deadline',
        'beneficiary_name',
        'beneficiary_story',
        'supporting_documents',
        'status'
    ];

    protected $casts = [
        'supporting_documents' => 'array',
        'deadline' => 'date',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(PublicUser::class, 'public_user_id');
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount > 0) {
            return min(100, round(($this->current_amount / $this->target_amount) * 100));
        }
        return 0;
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'green',
            'completed' => 'blue',
            'cancelled' => 'red',
            'expired' => 'gray',
            default => 'gray'
        };
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->deadline) {
            return max(0, now()->diffInDays($this->deadline, false));
        }
        return 0;
    }

    public function isExpired()
    {
        return $this->deadline && $this->deadline->isPast();
    }
}