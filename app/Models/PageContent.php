<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageContent extends Model
{
    use HasFactory;

    protected $table = 'page_content';

    protected $fillable = [
        'section_name',
        'title',
        'content',
        'images',
        'settings',
        'is_active',
        'sort_order',
        'user_id',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get the user who created/updated this content
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get sections by name
     */
    public function scopeBySection($query, $sectionName)
    {
        return $query->where('section_name', $sectionName);
    }

    /**
     * Get section display name with emoji
     */
    public function getDisplayNameAttribute(): string
    {
        return match($this->section_name) {
            'statistics' => '📊 Statistics',
            'about' => '👤 About Section',
            'initiatives' => '🎯 Initiatives',
            'contact' => '📞 Contact Info',
            default => ucfirst($this->section_name)
        };
    }

    /**
     * Ensure section_name is normalized (slug-like)
     */
    public function setSectionNameAttribute(string $value): void
    {
        $normalized = strtolower(trim($value));
        $normalized = preg_replace('/[^a-z0-9\-]+/i', '-', $normalized);
        $normalized = trim(preg_replace('/-+/', '-', $normalized), '-');
        $this->attributes['section_name'] = $normalized ?: 'custom-section';
    }

    /**
     * Get first image from images array
     */
    public function getFirstImageAttribute(): ?string
    {
        if (is_array($this->images) && !empty($this->images)) {
            return $this->images[0] ?? null;
        }
        return null;
    }

    /**
     * Get all images as array
     */
    public function getImagesArrayAttribute(): array
    {
        if (is_array($this->images)) {
            return $this->images;
        }
        return [];
    }

    /**
     * Check if section has images
     */
    public function hasImages(): bool
    {
        return !empty($this->images_array);
    }

    /**
     * Get setting value
     */
    public function getSetting(string $key, $default = null)
    {
        $settings = $this->getSettingsArray();
        return $settings[$key] ?? $default;
    }

    /**
     * Set setting value
     */
    public function setSetting(string $key, $value): void
    {
        $settings = $this->getSettingsArray();
        $settings[$key] = $value;
        $this->settings = json_encode($settings);
    }

    /**
     * Get settings as array
     */
    public function getSettingsArray(): array
    {
        if (empty($this->settings)) {
            return [];
        }
        
        if (is_string($this->settings)) {
            $decoded = json_decode($this->settings, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        return [];
    }

    /**
     * Mutator to ensure settings is stored as JSON string
     */
    public function setSettingsAttribute($value): void
    {
        if (is_string($value)) {
            // If it's already a JSON string, validate it
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['settings'] = $value;
            } else {
                $this->attributes['settings'] = json_encode([]);
            }
        } elseif (is_array($value)) {
            $this->attributes['settings'] = json_encode($value);
        } else {
            $this->attributes['settings'] = json_encode([]);
        }
    }
}
