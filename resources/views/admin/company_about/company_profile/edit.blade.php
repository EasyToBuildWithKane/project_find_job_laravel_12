@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Edit Section')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Edit Company Profile Section</h2>
                <p class="text-muted mb-0">Update the details of this section below.</p>
            </div>
            <a href="{{ route('admin.company_about.company_profile.index') }}" class="btn btn-primary">
                ← Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="companyProfileForm" method="POST"
                    action="{{ route('admin.company_about.company_profile.update', $profile->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Section Key -->
                        <div class="col-md-6">
                            <label class="form-label">Section Key</label>
                            <input type="text" class="form-control @error('section_key') is-invalid @enderror"
                                name="section_key" value="{{ old('section_key', $profile->section_key) }}" readonly>
                            @error('section_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $profile->title) }}" placeholder="Enter section title">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Headline -->
                        <div class="col-md-6">
                            <label class="form-label">Headline</label>
                            <input type="text" class="form-control @error('headline') is-invalid @enderror"
                                name="headline" value="{{ old('headline', $profile->headline) }}"
                                placeholder="Enter headline">
                            @error('headline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CTA Label -->
                        <div class="col-md-6">
                            <label class="form-label">CTA Label</label>
                            <input type="text" class="form-control @error('cta_label') is-invalid @enderror"
                                name="cta_label" value="{{ old('cta_label', $profile->cta_label) }}"
                                placeholder="Button text">
                            @error('cta_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CTA Link -->
                        <div class="col-md-6">
                            <label class="form-label">CTA Link</label>
                            <input type="text" class="form-control @error('cta_link') is-invalid @enderror"
                                name="cta_link" value="{{ old('cta_link', $profile->cta_link) }}"
                                placeholder="https://example.com">
                            @error('cta_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Summary -->
                        <div class="col-md-6">
                            <label class="form-label">Summary</label>
                            <textarea class="form-control @error('summary') is-invalid @enderror" name="summary" rows="3"
                                placeholder="Short summary">{{ old('summary', $profile->summary) }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div class="col-12">
                            <label class="form-label">Body</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" rows="5"
                                placeholder="Detailed description">{{ old('body', $profile->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div class="col-12">
                            <label class="form-label">Featured Image</label>
                            <input type="file" class="form-control @error('featured_image_url') is-invalid @enderror"
                                name="featured_image_url" id="featured_image_url">
                            @error('featured_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 d-flex flex-column align-items-start gap-2">
                                <img id="featuredImagePreview"
                                    src="{{ $profile->featured_image_url ? asset($profile->featured_image_url) : asset('uploads/no_image.jpg') }}"
                                    alt="Featured" class="img-thumbnail"
                                    style="height:80px; width:auto; display: {{ $profile->featured_image_url ? 'block' : asset('uploads/no_image.jpg') }};">

                                <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm"
                                    style="display: {{ $profile->featured_image_url ? 'inline-block' : 'none' }};">
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
                            <button type="button" class="btn btn-secondart" id="resetBtn"
                                style="min-width: 100%">Reset</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.company_profile.script')
