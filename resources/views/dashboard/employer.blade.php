@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Employer Dashboard</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Posted Jobs</h5>
                    <h2>{{ $jobs->count() }}</h2>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post New Job</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Applications Received</h5>
                    <h2>{{ $applications->count() }}</h2>
                    <a href="{{ route('employer.jobs') }}" class="btn btn-primary">View Applications</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Company Profile</h5>
                    <p>{{ $user->employer->company_name ?? 'Not set' }}</p>
                    <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <h3>Recent Jobs</h3>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Applications</th>
                        <th>Posted Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                        <tr>
                            <td>{{ $job->title }}</td>
                            <td><span class="badge bg-{{ $job->status === 'published' ? 'success' : 'secondary' }}">{{ $job->status }}</span></td>
                            <td>{{ $job->applications_count }}</td>
                            <td>{{ $job->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No jobs posted yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
