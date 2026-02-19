<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\SkillTest;
use App\Models\Roadmap;
use App\Models\Employer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_employers' => Employer::count(),
            'total_jobs' => Job::count(),
            'active_jobs' => Job::where('status', 'published')->count(),
            'total_applications' => JobApplication::count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'total_skill_tests' => SkillTest::count(),
            'total_roadmaps' => Roadmap::count(),
        ];

        $recentUsers = User::latest()->take(10)->get();
        $recentJobs = Job::with('employer')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentJobs'));
    }

    /**
     * Display a listing of users.
     */
    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a listing of jobs.
     */
    public function jobs()
    {
        $jobs = Job::with('employer')->paginate(20);
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Display a listing of skill tests.
     */
    public function skillTests()
    {
        $tests = SkillTest::paginate(20);
        return view('admin.skill-tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new skill test.
     */
    public function createSkillTest()
    {
        return view('admin.skill-tests.create');
    }

    /**
     * Store a newly created skill test.
     */
    public function storeSkillTest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skill_category' => 'required|string',
            'difficulty' => 'required|in:beginner,intermediate,advanced,expert',
            'duration_minutes' => 'required|integer|min:1',
            'questions' => 'required|array',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        SkillTest::create($validated);

        return redirect()->route('admin.skill-tests')->with('success', 'Skill test created successfully!');
    }

    /**
     * Display a listing of roadmaps.
     */
    public function roadmaps()
    {
        $roadmaps = Roadmap::paginate(20);
        return view('admin.roadmaps.index', compact('roadmaps'));
    }

    /**
     * Show the form for creating a new roadmap.
     */
    public function createRoadmap()
    {
        return view('admin.roadmaps.create');
    }

    /**
     * Store a newly created roadmap.
     */
    public function storeRoadmap(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'career_path' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'milestones' => 'required|array',
            'resources' => 'nullable|array',
            'estimated_duration_weeks' => 'nullable|integer|min:1',
            'is_published' => 'boolean',
        ]);

        Roadmap::create($validated);

        return redirect()->route('admin.roadmaps')->with('success', 'Roadmap created successfully!');
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
    }

    /**
     * Delete a job.
     */
    public function deleteJob(Job $job)
    {
        $job->delete();
        return back()->with('success', 'Job deleted successfully!');
    }
}
