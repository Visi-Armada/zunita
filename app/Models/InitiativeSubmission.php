<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitiativeSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_user_id',
        'title',
        'description',
        'category',
        'objectives',
        'expected_outcomes',
        'estimated_budget',
        'target_beneficiaries',
        'proposed_start_date',
        'proposed_end_date',
        'location',
        'supporting_documents',
        'status',
        'admin_feedback'
    ];

    protected $casts = [
        'supporting_documents' => 'array',
        'proposed_start_date' => 'date',
        'proposed_end_date' => 'date',
        'estimated_budget' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(PublicUser::class, 'public_user_id');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'submitted' => 'yellow',
            'under_review' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'implemented' => 'purple',
            default => 'gray'
        };
    }

    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'community_development' => 'Community Development',
            'education' => 'Education',
            'healthcare' => 'Healthcare',
            'infrastructure' => 'Infrastructure',
            'environment' => 'Environment',
            'economic' => 'Economic',
            'social' => 'Social',
            'cultural' => 'Cultural',
            'sports' => 'Sports',
            'technology' => 'Technology',
            default => $this->category
        };
    }

    public function getDurationAttribute()
    {
        if ($this->proposed_start_date && $this->proposed_end_date) {
            return $this->proposed_start_date->diffInDays($this->proposed_end_date);
        }
        return 0;
    }
}