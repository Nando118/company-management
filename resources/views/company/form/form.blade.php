@extends('layouts.app')

@section('content_header')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('company.index') }}">Companies</a></li>
            @if(isset($userData))
                <li class="breadcrumb-item active" aria-current="page">Edit Company</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Add Company</li>
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

                    @if(isset($companyData))
                        <input type="hidden" name="id" value="{{ $companyData->id }}">
                    @endif

                    <div class="form-group">
                        <label for="company_name">Company Name<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('company_name') is-invalid @enderror" id="company_name" name="company_name" value="{{ old('company_name') ?? (isset($companyData) ? $companyData->name : '') }}">
                        @error('company_name')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company_email">Company Email Address<span style="color: red;">*</span></label>
                        <input type="company_email" class="form-control @error('company_email') is-invalid @enderror" id="company_email" aria-describedby="emailHelp" name="company_email" value="{{ old('company_email') ?? (isset($companyData) ? $companyData->email : '') }}">
                        @if(isset($companyData))
                            <small id="emailHelp" class="form-text text-muted">Please enter a valid email if you want to change your email address.</small>
                        @else
                            <small id="emailHelp" class="form-text text-muted">Please enter a valid email.</small>
                        @endif
                        @error('company_email')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company_website">Company Website<span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('company_website') is-invalid @enderror" id="company_website" name="company_website" value="{{ old('company_website') ?? (isset($companyData) ? $companyData->website : '') }}">
                        @error('company_website')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if(isset($companyData))
                        <div class="form-group">
                            <label for="company_logo">Current Company Logo</label>
                            <br>
                            <img src="{{ asset('storage/'.$companyData->logo) }}" alt="{{ $companyData->name ."-logo.jpg" }}" class="border" style="width: 250px; height: 250px;">
                            <input type="hidden" name="oldLogo" value="{{ 'public/'.$companyData->logo }}">
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="company_logo">Company Logo<span style="color: red;">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('company_logo') is-invalid @enderror" id="inputGroupFile01" name="company_logo" aria-describedby="inputGroupFileAddon01" accept=".png, .jpg, .jpeg">
                                <label class="custom-file-label" for="inputGroupFile01">{{ $logoFileName ?? 'Choose file' }}</label>
                            </div>
                        </div>
                        @if(isset($companyData))
                            <small id="inputGroupFile01" class="form-text text-muted">Please upload a new Company Logo if you want to change your Company Logo.</small>
                        @endif
                        @error('company_logo')
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Add Company</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("scripts")
    <script>
        $(document).ready(function () {
            bsCustomFileInput.init()
        })
    </script>
@endpush
