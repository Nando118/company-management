@extends('layouts.app')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-footer">
                                <div class="card-title font-weight-bold"><i class="fas fa-user"></i> Total Users</div>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text h2">{{ $users }} Users</p>
                                <div class="btn-group mr-1">
                                    <a href="{{ route('user.index') }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('user.create') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-footer">
                                <div class="card-title font-weight-bold"><i class="fas fa-building"></i> Total Companies</div>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text h2">{{ $companies }} Companies</p>
                                <div class="btn-group mr-1">
                                    <a href="{{ route('company.index') }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('company.create') }}" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-footer">
                                <div class="card-title font-weight-bold"><i class="fas fa-users"></i> Total Employees</div>
                            </div>
                            <div class="card-body text-center">
                                <p class="card-text h2">{{ $employees }} Employees</p>
                                <div class="btn-group mr-1">
                                    <a href="{{ route('employee.index') }}" class="btn btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-success"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
