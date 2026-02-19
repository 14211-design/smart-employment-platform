<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'company_description',
        'company_website',
        'company_logo',
        'industry',
        'company_size',
        'location',
    ];

    /**
     * Get the user that owns the employer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the jobs posted by this employer.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
