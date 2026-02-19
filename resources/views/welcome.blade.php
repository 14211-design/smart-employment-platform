@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <div class="text-center py-5">
        <h1 class="display-4">Welcome to Smart Employment Platform</h1>
        <p class="lead">Connect job seekers with employers and build your career</p>
        
        <div class="mt-5">
            <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-lg me-2">Browse Jobs</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Get Started</a>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3>Find Jobs</h3>
                    <p>Browse thousands of job opportunities from top employers</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3>Take Skill Tests</h3>
                    <p>Prove your skills and get certified in various domains</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h3>Career Roadmaps</h3>
                    <p>Follow structured learning paths for your career goals</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
