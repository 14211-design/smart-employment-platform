<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:255',
            'skills' => 'nullable|array',
            'avatar' => 'nullable|image|max:2048',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($user->resume) {
                Storage::disk('public')->delete($user->resume);
            }
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $user->update($validated);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Show the user's dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isEmployer()) {
            $jobs = $user->employer->jobs()->latest()->take(5)->get();
            $applications = \App\Models\JobApplication::whereIn('job_id', $user->employer->jobs->pluck('id'))
                ->latest()
                ->take(10)
                ->get();
            
            return view('dashboard.employer', compact('user', 'jobs', 'applications'));
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            $applications = $user->jobApplications()->with('job')->latest()->get();
            $recommendedJobs = \App\Models\Job::active()->latest()->take(10)->get();
            
            return view('dashboard.job-seeker', compact('user', 'applications', 'recommendedJobs'));
        }
    }

    /**
     * Show user's job applications.
     */
    public function applications()
    {
        $user = Auth::user();
        $applications = $user->jobApplications()->with('job')->paginate(10);

        return view('user.applications', compact('applications'));
    }

    /**
     * Show user's skill test results.
     */
    public function skillTests()
    {
        $user = Auth::user();
        $completedTests = $user->skillTests()->wherePivot('status', 'completed')->get();

        return view('user.skill-tests', compact('completedTests'));
    }
}
