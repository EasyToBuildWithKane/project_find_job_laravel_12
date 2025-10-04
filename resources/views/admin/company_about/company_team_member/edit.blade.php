@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Edit Team Member')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Edit Team Member</h2>
                <p class="text-muted mb-0">Update the details of this team member below.</p>
            </div>
            <a href="{{ route('admin.company_about.company_team_member.index') }}" class="btn btn-primary">
                ← Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="teamMemberForm" method="POST"
                    action="{{ route('admin.company_about.company_team_member.update', $member->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                name="full_name" value="{{ old('full_name', $member->full_name) }}"
                                placeholder="Enter full name">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Job Title -->
                        <div class="col-md-6">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror"
                                name="job_title" value="{{ old('job_title', $member->job_title) }}"
                                placeholder="Enter job title">
                            @error('job_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror"
                                name="department" value="{{ old('department', $member->department) }}"
                                placeholder="Enter department">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-md-6">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                name="location" value="{{ old('location', $member->location) }}"
                                placeholder="Enter location">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <!-- Featured -->
                        <div class="col-md-3 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <label class="form-check-label" for="is_featured">Featured</label>
                                <select name="is_featured" id="is_featured">
                                    <option value="1">True</option>
                                    <option value="0">False </option>
                                </select>

                            </div>
                        </div>

                        <!-- Profile Image -->
                        <div class="col-12">
                            <label class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('profile_image_url') is-invalid @enderror"
                                name="profile_image_url" id="profile_image_url">
                            @error('profile_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 d-flex flex-column align-items-start gap-2">
                                <img id="profileImagePreview"
                                    src="{{ $member->profile_image_url ? asset($member->profile_image_url) : asset('uploads/no_image.jpg') }}"
                                    alt="Profile" class="img-thumbnail" style="height:80px; width:auto;">

                                <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm"
                                    style="display: {{ $member->profile_image_url ? 'inline-block' : 'none' }};">
                                    Remove
                                </button>
                            </div>
                        </div>

                    </div> <!-- /row -->

                    <!-- Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="submitBtn" style="min-width: 100%">
                                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                                <span class="btn-text">Update</span>
                            </button>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-secondary" id="resetBtn"
                                style="min-width: 100%">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.company_team_member.script')
