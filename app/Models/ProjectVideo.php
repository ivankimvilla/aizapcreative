<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function storageDiskName(): string
    {
        return env('PROJECT_VIDEO_DISK', env('FILESYSTEM_DISK', 'public'));
    }

    protected function storageDisk(): string
    {
        return self::storageDiskName();
    }

    public function getVideoUrlAttribute(): ?string
    {
        if (empty($this->video_path)) {
            return null;
        }

        return Storage::disk($this->storageDisk())->url($this->video_path);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (empty($this->cover_path)) {
            return null;
        }

        return Storage::disk($this->storageDisk())->url($this->cover_path);
    }
}
