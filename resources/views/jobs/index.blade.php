@extends('layouts.app')

@section('title', 'Browse Jobs')

@section('content')
<div class="container">
    <h1 class="mb-4">Browse Jobs</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <form method="GET" action="{{ route('jobs.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search jobs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
                </div>
                <div class="col-md-2">
                    <select name="job_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="full-time" {{ request('job_type') === 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ request('job_type') === 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="contract" {{ request('job_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                        <option value="remote" {{ request('job_type') === 'remote' ? 'selected' : '' }}>Remote</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse($jobs as $job)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $job->title }}</h5>
                        <p class="text-muted">{{ $job->employer->company_name }}</p>
                        <p class="card-text">{{ Str::limit($job->description, 150) }}</p>
                        <p><strong>Location:</strong> {{ $job->location }}</p>
                        <p><strong>Type:</strong> {{ $job->job_type }}</p>
                        @if($job->salary_min && $job->salary_max)
                            <p><strong>Salary:</strong> ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                        @endif
                        <a href="{{ route('jobs.show', $job) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No jobs found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
