<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadmap extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'career_path',
        'level',
        'milestones',
        'resources',
        'estimated_duration_weeks',
        'is_published',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'milestones' => 'array',
            'resources' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Scope a query to only include published roadmaps.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope a query to filter by career path.
     */
    public function scopeCareerPath($query, $careerPath)
    {
        return $query->where('career_path', $careerPath);
    }

    /**
     * Scope a query to filter by level.
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }
}
