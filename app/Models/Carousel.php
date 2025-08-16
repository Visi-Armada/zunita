<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carousel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image',
        'alt_text',
        'link_url',
        'button_text',
        'order',
        'is_active',
        'start_date',
        'end_date',
        'user_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('start_date')
                          ->orWhere('start_date', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', now());
                    });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // If using Supabase storage
        if (env('SUPABASE_URL')) {
            return env('SUPABASE_URL') . '/storage/v1/object/public/' . env('SUPABASE_BUCKET', 'uploads') . '/' . $this->image;
        }

        // Fallback to local storage
        return asset('storage/' . $this->image);
    }

    public function getIsCurrentlyActiveAttribute()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }
}
