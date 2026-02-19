<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillTest extends Model
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
        'skill_category',
        'difficulty',
        'duration_minutes',
        'questions',
        'passing_score',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'questions' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the users who have taken this skill test.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill_tests')
            ->withPivot('status', 'score', 'answers', 'started_at', 'completed_at')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include active tests.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by difficulty.
     */
    public function scopeDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('skill_category', $category);
    }
}
