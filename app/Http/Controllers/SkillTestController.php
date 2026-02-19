<?php

namespace App\Http\Controllers;

use App\Models\SkillTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillTestController extends Controller
{
    /**
     * Display a listing of skill tests.
     */
    public function index()
    {
        $tests = SkillTest::active()->paginate(config('employment.pagination.tests_per_page', 10));
        return view('skill-tests.index', compact('tests'));
    }

    /**
     * Display the specified skill test.
     */
    public function show(SkillTest $skillTest)
    {
        $userTest = null;
        
        if (Auth::check()) {
            $userTest = Auth::user()->skillTests()
                ->where('skill_test_id', $skillTest->id)
                ->first();
        }

        return view('skill-tests.show', compact('skillTest', 'userTest'));
    }

    /**
     * Start a skill test.
     */
    public function start(SkillTest $skillTest)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to take skill tests.');
        }

        $existingTest = Auth::user()->skillTests()
            ->where('skill_test_id', $skillTest->id)
            ->first();

        if ($existingTest && $existingTest->pivot->status === 'completed') {
            return back()->with('error', 'You have already completed this test.');
        }

        if ($existingTest && $existingTest->pivot->status === 'in_progress') {
            return redirect()->route('skill-tests.take', $skillTest);
        }

        Auth::user()->skillTests()->attach($skillTest->id, [
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('skill-tests.take', $skillTest);
    }

    /**
     * Take the skill test.
     */
    public function take(SkillTest $skillTest)
    {
        $userTest = Auth::user()->skillTests()
            ->where('skill_test_id', $skillTest->id)
            ->first();

        if (!$userTest || $userTest->pivot->status !== 'in_progress') {
            return redirect()->route('skill-tests.show', $skillTest)
                ->with('error', 'Invalid test session.');
        }

        return view('skill-tests.take', compact('skillTest', 'userTest'));
    }

    /**
     * Submit the skill test answers.
     */
    public function submit(Request $request, SkillTest $skillTest)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $userTest = Auth::user()->skillTests()
            ->where('skill_test_id', $skillTest->id)
            ->first();

        if (!$userTest || $userTest->pivot->status !== 'in_progress') {
            return back()->with('error', 'Invalid test session.');
        }

        // Calculate score (simplified - in real app, compare with correct answers)
        $score = $this->calculateScore($validated['answers'], $skillTest->questions);

        Auth::user()->skillTests()->updateExistingPivot($skillTest->id, [
            'status' => 'completed',
            'score' => $score,
            'answers' => $validated['answers'],
            'completed_at' => now(),
        ]);

        return redirect()->route('skill-tests.result', $skillTest)
            ->with('success', 'Test submitted successfully!');
    }

    /**
     * Show the test result.
     */
    public function result(SkillTest $skillTest)
    {
        $userTest = Auth::user()->skillTests()
            ->where('skill_test_id', $skillTest->id)
            ->first();

        if (!$userTest || $userTest->pivot->status !== 'completed') {
            return redirect()->route('skill-tests.show', $skillTest)
                ->with('error', 'Test not completed yet.');
        }

        $passed = $userTest->pivot->score >= $skillTest->passing_score;

        return view('skill-tests.result', compact('skillTest', 'userTest', 'passed'));
    }

    /**
     * Calculate the test score based on answers.
     */
    private function calculateScore(array $answers, ?array $questions): int
    {
        if (!$questions) {
            return 0;
        }

        $correct = 0;
        $total = count($questions);

        foreach ($questions as $index => $question) {
            if (isset($answers[$index]) && isset($question['correct_answer'])) {
                if ($answers[$index] == $question['correct_answer']) {
                    $correct++;
                }
            }
        }

        return $total > 0 ? round(($correct / $total) * 100) : 0;
    }
}
