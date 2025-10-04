@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Edit Why Choose Us')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Edit Why Choose Us</h2>
                <p class="text-muted mb-0">Update the details of this section item below.</p>
            </div>
            <a href="{{ route('admin.company_about.why_choose_us.index') }}" class="btn btn-primary">
                ← Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="whyChooseUsForm" method="POST"
                      action="{{ route('admin.company_about.why_choose_us.update', $item->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Section Title -->
                        <div class="col-md-6">
                            <label class="form-label">Section Title</label>
                            <input type="text" class="form-control @error('section_title') is-invalid @enderror"
                                   name="section_title" value="{{ old('section_title', $item->section_title) }}"
                                   placeholder="e.g. Why Choose Us">
                            @error('section_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Section Subtitle -->
                        <div class="col-md-6">
                            <label class="form-label">Section Subtitle</label>
                            <input type="text" class="form-control @error('section_subtitle') is-invalid @enderror"
                                   name="section_subtitle" value="{{ old('section_subtitle', $item->section_subtitle) }}"
                                   placeholder="e.g. You will find your ideal candidates…">
                            @error('section_subtitle')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Item Title -->
                        <div class="col-md-6">
                            <label class="form-label">Item Title</label>
                            <input type="text" class="form-control @error('item_title') is-invalid @enderror"
                                   name="item_title" value="{{ old('item_title', $item->item_title) }}"
                                   placeholder="e.g. Cost Effective">
                            @error('item_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Item Description -->
                        <div class="col-md-6">
                            <label class="form-label">Item Description</label>
                            <textarea class="form-control @error('item_description') is-invalid @enderror"
                                      name="item_description"
                                      placeholder="Enter item description">{{ old('item_description', $item->item_description) }}</textarea>
                            @error('item_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <button type="submit" class="btn btn-primary d-flex align-items-center" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="submitSpinner"></span>
                                <span class="btn-text">Update</span>
                            </button>
                            <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
 