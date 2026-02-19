<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    /**
     * Determine if the user can create jobs.
     */
    public function create(User $user): bool
    {
        return $user->isEmployer();
    }

    /**
     * Determine if the user can update the job.
     */
    public function update(User $user, Job $job): bool
    {
        return $user->isEmployer() && 
               $user->employer && 
               $user->employer->id === $job->employer_id;
    }

    /**
     * Determine if the user can delete the job.
     */
    public function delete(User $user, Job $job): bool
    {
        return $user->isEmployer() && 
               $user->employer && 
               $user->employer->id === $job->employer_id;
    }

    /**
     * Determine if the user can view the job.
     */
    public function view(?User $user, Job $job): bool
    {
        // Anyone can view published jobs
        if ($job->status === 'published') {
            return true;
        }

        // Owners can view their own jobs
        if ($user && $user->isEmployer() && $user->employer) {
            return $user->employer->id === $job->employer_id;
        }

        return false;
    }
}
