@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $stats['total_users'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Employers</h5>
                    <h2>{{ $stats['total_employers'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Jobs</h5>
                    <h2>{{ $stats['total_jobs'] }}</h2>
                    <small>({{ $stats['active_jobs'] }} active)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Applications</h5>
                    <h2>{{ $stats['total_applications'] }}</h2>
                    <small>({{ $stats['pending_applications'] }} pending)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Skill Tests</h5>
                    <h2>{{ $stats['total_skill_tests'] }}</h2>
                    <a href="{{ route('admin.skill-tests') }}" class="btn btn-sm btn-primary mt-2">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Roadmaps</h5>
                    <h2>{{ $stats['total_roadmaps'] }}</h2>
                    <a href="{{ route('admin.roadmaps') }}" class="btn btn-sm btn-primary mt-2">Manage</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Recent Users</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-info">{{ $user->role }}</span></td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No users yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <h3>Recent Jobs</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Company</th>
                            <th>Status</th>
                            <th>Posted</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentJobs as $job)
                            <tr>
                                <td>{{ Str::limit($job->title, 30) }}</td>
                                <td>{{ $job->employer->company_name }}</td>
                                <td><span class="badge bg-{{ $job->status === 'published' ? 'success' : 'secondary' }}">{{ $job->status }}</span></td>
                                <td>{{ $job->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No jobs yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.users') }}" class="btn btn-primary me-2">Manage Users</a>
        <a href="{{ route('admin.jobs') }}" class="btn btn-primary me-2">Manage Jobs</a>
        <a href="{{ route('admin.skill-tests.create') }}" class="btn btn-success me-2">Create Skill Test</a>
        <a href="{{ route('admin.roadmaps.create') }}" class="btn btn-success">Create Roadmap</a>
    </div>
</div>
@endsection
