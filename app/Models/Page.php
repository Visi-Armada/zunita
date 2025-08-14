<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'published_at',
        'user_id',
        'parent_id',
        'order',
        'template',
        'featured_image',
        'is_homepage',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_homepage' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'published_at',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHomepage($query)
    {
        return $query->where('is_homepage', true);
    }

    // Accessors
    public function getFullUrlAttribute(): string
    {
        return url('/pages/' . $this->slug);
    }

    public function getExcerptAttribute(): string
    {
        return \Str::limit(strip_tags($this->content), 200);
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
}
