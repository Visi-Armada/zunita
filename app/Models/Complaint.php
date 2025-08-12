<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'public_user_id',
        'title',
        'description',
        'category',
        'location',
        'latitude',
        'longitude',
        'priority',
        'status',
        'attachments',
        'admin_response',
        'resolved_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'resolved_at' => 'datetime'
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
            'in_progress' => 'orange',
            'resolved' => 'green',
            'closed' => 'gray',
            default => 'gray'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'urgent' => 'red',
            default => 'gray'
        };
    }
}