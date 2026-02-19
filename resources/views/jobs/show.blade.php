@extends('layouts.app')

@section('title', 'Job Details')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h1>{{ $job->title }}</h1>
                    <p class="text-muted">
                        <strong>{{ $job->employer->company_name }}</strong> | 
                        {{ $job->location }} | 
                        {{ $job->job_type }}
                    </p>
                    
                    @if($job->salary_min && $job->salary_max)
                        <p><strong>Salary:</strong> ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}</p>
                    @endif

                    @if($job->experience_level)
                        <p><strong>Experience Level:</strong> {{ ucfirst($job->experience_level) }}</p>
                    @endif

                    <h3 class="mt-4">Job Description</h3>
                    <p>{{ $job->description }}</p>

                    @if($job->requirements)
                        <h3 class="mt-4">Requirements</h3>
                        <p>{{ $job->requirements }}</p>
                    @endif

                    @if($job->skills_required)
                        <h3 class="mt-4">Required Skills</h3>
                        <div>
                            @foreach($job->skills_required as $skill)
                                <span class="badge bg-primary me-1">{{ $skill }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        <p class="text-muted">Posted {{ $job->created_at->diffForHumans() }}</p>
                        @if($job->expires_at)
                            <p class="text-muted">Expires {{ $job->expires_at->format('M d, Y') }}</p>
                        @endif
                        <p class="text-muted">{{ $job->applications_count }} applications</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    @auth
                        @if($hasApplied)
                            <div class="alert alert-info">
                                You have already applied for this job.
                            </div>
                        @elseif(auth()->user()->isEmployer())
                            <div class="alert alert-warning">
                                Employers cannot apply for jobs.
                            </div>
                        @else
                            <form method="POST" action="{{ route('jobs.apply', $job) }}" enctype="multipart/form-data">
                                @csrf
                                <h5>Apply for this Job</h5>
                                
                                <div class="mb-3">
                                    <label for="cover_letter" class="form-label">Cover Letter (Optional)</label>
                                    <textarea class="form-control" id="cover_letter" name="cover_letter" rows="5"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="resume" class="form-label">Resume (Optional)</label>
                                    <input type="file" class="form-control" id="resume" name="resume" accept=".pdf,.doc,.docx">
                                    <small class="text-muted">PDF, DOC, DOCX - Max 5MB</small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Submit Application</button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-info">
                            Please <a href="{{ route('login') }}">login</a> to apply for this job.
                        </div>
                    @endauth

                    <hr>

                    <h5>About {{ $job->employer->company_name }}</h5>
                    @if($job->employer->company_description)
                        <p>{{ Str::limit($job->employer->company_description, 200) }}</p>
                    @endif

                    @if($job->employer->company_website)
                        <a href="{{ $job->employer->company_website }}" target="_blank" class="btn btn-outline-primary">Visit Website</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
