@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Job Seeker Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">My Applications</h5>
                    <h2>{{ $applications->count() }}</h2>
                    <a href="{{ route('user.applications') }}" class="btn btn-primary">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Skill Tests</h5>
                    <h2>{{ $user->skillTests->count() }}</h2>
                    <a href="{{ route('skill-tests.index') }}" class="btn btn-primary">Take Tests</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p>{{ $user->name }}</p>
                    <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Recommended Jobs</h3>
        <div class="row">
            @forelse($recommendedJobs as $job)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                            <p><strong>Location:</strong> {{ $job->location }}</p>
                            <p><strong>Type:</strong> {{ $job->job_type }}</p>
                            <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No jobs available at the moment.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
