<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_user_id',
        'application_number',
        'type',
        'title',
        'description',
        'requested_amount',
        'justification',
        'supporting_documents',
        'status',
        'approved_amount',
        'admin_notes',
        'decision_date',
        'disbursement_date'
    ];

    protected $casts = [
        'supporting_documents' => 'array',
        'decision_date' => 'date',
        'disbursement_date' => 'date',
        'requested_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(PublicUser::class, 'public_user_id');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($application) {
            $application->application_number = 'APP-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
        });
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'submitted' => 'yellow',
            'under_review' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'disbursed' => 'purple',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'financial_assistance' => 'Financial Assistance',
            'medical_assistance' => 'Medical Assistance',
            'education_assistance' => 'Education Assistance',
            'housing_assistance' => 'Housing Assistance',
            'business_assistance' => 'Business Assistance',
            'emergency_assistance' => 'Emergency Assistance',
            'skill_training' => 'Skill Training',
            'equipment_assistance' => 'Equipment Assistance',
            default => $this->type
        };
    }
}