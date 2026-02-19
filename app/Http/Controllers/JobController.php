<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of jobs.
     */
    public function index(Request $request)
    {
        $query = Job::with('employer')->active();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('location')) {
            $query->where('location', 'like', "%{$request->input('location')}%");
        }

        if ($request->has('job_type')) {
            $query->where('job_type', $request->input('job_type'));
        }

        if ($request->has('experience_level')) {
            $query->where('experience_level', $request->input('experience_level'));
        }

        $jobs = $query->paginate(config('employment.pagination.jobs_per_page', 15));

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job.
     */
    public function show(Job $job)
    {
        $job->load('employer');
        $hasApplied = false;

        if (Auth::check()) {
            $hasApplied = JobApplication::where('job_id', $job->id)
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('jobs.show', compact('job', 'hasApplied'));
    }

    /**
     * Show the form for creating a new job.
     */
    public function create()
    {
        $this->authorize('create', Job::class);
        return view('jobs.create');
    }

    /**
     * Store a newly created job.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'experience_level' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'skills_required' => 'nullable|array',
            'expires_at' => 'nullable|date|after:today',
        ]);

        $validated['employer_id'] = Auth::user()->employer->id;
        $validated['status'] = $request->has('publish') ? 'published' : 'draft';
        
        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $job = Job::create($validated);

        return redirect()->route('jobs.show', $job)->with('success', 'Job posted successfully!');
    }

    /**
     * Show the form for editing the specified job.
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);
        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job.
     */
    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
            'experience_level' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0',
            'skills_required' => 'nullable|array',
            'status' => 'required|in:draft,published,closed,filled',
            'expires_at' => 'nullable|date',
        ]);

        if ($validated['status'] === 'published' && !$job->published_at) {
            $validated['published_at'] = now();
        }

        $job->update($validated);

        return redirect()->route('jobs.show', $job)->with('success', 'Job updated successfully!');
    }

    /**
     * Remove the specified job.
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);
        $job->delete();

        return redirect()->route('dashboard')->with('success', 'Job deleted successfully!');
    }

    /**
     * Apply for a job.
     */
    public function apply(Request $request, Job $job)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to apply for jobs.');
        }

        if (Auth::user()->isEmployer()) {
            return back()->with('error', 'Employers cannot apply for jobs.');
        }

        $existingApplication = JobApplication::where('job_id', $job->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingApplication) {
            return back()->with('error', 'You have already applied for this job.');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        $validated['job_id'] = $job->id;
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        JobApplication::create($validated);

        $job->increment('applications_count');

        return redirect()->route('jobs.show', $job)->with('success', 'Application submitted successfully!');
    }
}
