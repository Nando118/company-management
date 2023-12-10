@extends('layouts.app')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Employees</a></li>
            @if(isset($employeeData))
                <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
            @endif
        </ol>
    </nav>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ $action }}" method="{{ $method }}" enctype="multipart/form-data">
                    @csrf

                    @if(isset($employeeData))
                        <input type="hidden" name="id" value="{{ $employeeData->id }}">
                    @endif

                    <div class="form-group">
                        <label for="first_name">First Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ?? (isset($employeeData) ? $employeeData->first_name : '') }}">
                        @error('first_name')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? (isset($employeeData) ? $employeeData->last_name : '') }}">
                        @error('last_name')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Work for the Company<span style="color: red;">*</span></label>
                        <select class="form-control @error('company_id') is-invalid @enderror" id="exampleFormControlSelect1" name="company_id">
                            @isset($employeeData->company_id)
                                <option value="{{ $employeeData->company->id }}" selected>
                                    {{ $employeeData->company->name }}
                                </option>
                            @endisset
                        </select>
                        @error('company_id')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email<span style="color: red;">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? (isset($employeeData) ? $employeeData->email : '') }}">
                        @error('email')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') ?? (isset($employeeData) ? $employeeData->phone : '') }}">
                        @error('phone')
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Add Employee</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        });

        $("#exampleFormControlSelect1").select2({
            placeholder: 'Select Company...',
            ajax: {
                url: '{{ route('employee.getCompanies') }}',
                dataType: 'json',
                processResults: function(data) {
                    return {
                        results: data.companies.map(function(company) {
                            return {
                                id: company.id,
                                text: company.name // Sesuaikan dengan kolom nama perusahaan
                            };
                        })
                    };
                }
            }
        });
    </script>
@endpush
