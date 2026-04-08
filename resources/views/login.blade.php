@extends('design')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center py-3">
                <h3 class="mb-0">Login Student</h3>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="row g-3">
                            <div class="col-auto">
                                <label class="form-label">Student Id</label>
                                <input type="text" class="form-control" name="student_id">
                            </div>
                            <div class="col-auto">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                    </div><br>
                    <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">No account? <a href="{{ route('register') }}" class="text-decoration-none">Register here</a></p>
                </div>

            </div>
        </div>
    </div>
</div>

