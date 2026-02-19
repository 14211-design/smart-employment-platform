<?php

namespace App\Http\Controllers;

use App\Models\Roadmap;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    /**
     * Display a listing of career roadmaps.
     */
    public function index()
    {
        $roadmaps = Roadmap::published()->get();
        return view('career.index', compact('roadmaps'));
    }

    /**
     * Display the specified career roadmap.
     */
    public function show(Roadmap $roadmap)
    {
        if (!$roadmap->is_published) {
            abort(404);
        }

        return view('career.show', compact('roadmap'));
    }

    /**
     * Display roadmaps for a specific career path.
     */
    public function careerPath($path)
    {
        $roadmaps = Roadmap::published()
            ->careerPath($path)
            ->get();

        return view('career.path', compact('roadmaps', 'path'));
    }

    /**
     * Display roadmaps for a specific level.
     */
    public function level($level)
    {
        $roadmaps = Roadmap::published()
            ->level($level)
            ->get();

        return view('career.level', compact('roadmaps', 'level'));
    }
}
