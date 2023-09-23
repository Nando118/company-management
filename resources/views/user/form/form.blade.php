@extends('layouts.app')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Users</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ $action }}" method="{{ $method }}">
                    @csrf

                    @if(isset($userData))
                        <input type="hidden" name="id" value="{{ $userData->id }}">
                    @endif

                    <div class="form-group">
                        <label for="name">Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') ?? (isset($userData) ? $userData->name : '') }}">
                        @error('name')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email address<span style="color: red;">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" name="email" value="{{ old('email') ?? (isset($userData) ? $userData->email : '') }}">
                        @if(isset($userData))
                            <small id="emailHelp" class="form-text text-muted">Please enter a valid email if you want to change your email address.</small>
                        @else
                            <small id="emailHelp" class="form-text text-muted">Please enter a valid email.</small>
                        @endif
                        @error('email')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password<span style="color: red;">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @if(isset($userData))
                            <small id="emailHelp" class="form-text text-muted">Please enter a new password if you want to change your password.</small>
                        @endif
                        @error('password')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Password Confirmation<span style="color: red;">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                        @error('password_confirmation')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Add User</button>
                </form>
            </div>
        </div>
    </div>
@endsection
