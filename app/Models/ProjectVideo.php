<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectVideo extends Model
{
    protected $fillable = [
        'title',
        'client',
        'category',
        'feature_category',
        'is_featured',
        'video_path',
        'cover_path',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->feature_category ?? $this->category) {
            'ai-commercial-ads' => 'AI Commercial Ads',
            'ai-product-ads' => 'AI Product Ads',
            'ai-storytelling-drama' => 'AI Storytelling / Drama',
            'ai-movie-trailers' => 'AI Movie Trailers',
            'ugc-style-ai-videos' => 'UGC-style AI Videos',
            'explainer-videos' => 'Explainer Videos',
            default => 'Featured Project',
        };
    }

    public function getVideoUrlAttribute(): ?string
    {
        if (empty($this->video_path)) {
            return null;
        }

        return asset('storage/' . ltrim($this->video_path, '/'));
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (empty($this->cover_path)) {
            return null;
        }

        return asset('storage/' . ltrim($this->cover_path, '/'));
    }
}
