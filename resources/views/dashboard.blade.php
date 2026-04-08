@extends('design')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> 
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="card-body p-4">
                    <div class="mb-5 text-center">
                        <h2 class="fw-bold">Welcome, {{ $user->first_name }} {{ $user->last_name }}!</h2>
                        <p class="text-muted">Student ID: {{ $user->student_id }}</p>
                    </div>
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm">
                                <a href="{{ route('user.profile') }}" class="btn btn-primary w-100">Update Student Profile</a>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger w-100">
                                    Logout Account
                                </button>
                            </form>
                        </div>
                    </div>
                    @if(session('success'))
                        <div class="alert alert-success mt-4">
                            {{ session('success') }}
                        </div>
                    @endif  
                </div>
            </div>
        </div>
    </div>
</div>