<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SkillTestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes (assuming you'll use Laravel Breeze or similar)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Public Job Routes
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');

// Public Career Routes
Route::get('/career-roadmaps', [CareerController::class, 'index'])->name('career.index');
Route::get('/career-roadmaps/{roadmap}', [CareerController::class, 'show'])->name('career.show');
Route::get('/career-path/{path}', [CareerController::class, 'careerPath'])->name('career.path');
Route::get('/career-level/{level}', [CareerController::class, 'level'])->name('career.level');

// Public Skill Test Routes
Route::get('/skill-tests', [SkillTestController::class, 'index'])->name('skill-tests.index');
Route::get('/skill-tests/{skillTest}', [SkillTestController::class, 'show'])->name('skill-tests.show');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    
    // User Profile Routes
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    Route::get('/my-applications', [UserController::class, 'applications'])->name('user.applications');
    Route::get('/my-skill-tests', [UserController::class, 'skillTests'])->name('user.skill-tests');
    
    // Job Application Routes
    Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    
    // Skill Test Routes (authenticated)
    Route::post('/skill-tests/{skillTest}/start', [SkillTestController::class, 'start'])->name('skill-tests.start');
    Route::get('/skill-tests/{skillTest}/take', [SkillTestController::class, 'take'])->name('skill-tests.take');
    Route::post('/skill-tests/{skillTest}/submit', [SkillTestController::class, 'submit'])->name('skill-tests.submit');
    Route::get('/skill-tests/{skillTest}/result', [SkillTestController::class, 'result'])->name('skill-tests.result');
});

// Employer Routes
Route::middleware(['auth', 'employer'])->group(function () {
    Route::get('/employer/jobs', [JobController::class, 'index'])->name('employer.jobs');
    Route::get('/employer/jobs/create', [JobController::class, 'create'])->name('jobs.create');
    Route::post('/employer/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::get('/employer/jobs/{job}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/employer/jobs/{job}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/employer/jobs/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Job Management
    Route::get('/jobs', [AdminController::class, 'jobs'])->name('jobs');
    Route::delete('/jobs/{job}', [AdminController::class, 'deleteJob'])->name('jobs.delete');
    
    // Skill Test Management
    Route::get('/skill-tests', [AdminController::class, 'skillTests'])->name('skill-tests');
    Route::get('/skill-tests/create', [AdminController::class, 'createSkillTest'])->name('skill-tests.create');
    Route::post('/skill-tests', [AdminController::class, 'storeSkillTest'])->name('skill-tests.store');
    
    // Roadmap Management
    Route::get('/roadmaps', [AdminController::class, 'roadmaps'])->name('roadmaps');
    Route::get('/roadmaps/create', [AdminController::class, 'createRoadmap'])->name('roadmaps.create');
    Route::post('/roadmaps', [AdminController::class, 'storeRoadmap'])->name('roadmaps.store');
});
