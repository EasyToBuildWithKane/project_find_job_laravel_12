@extends('admin.layouts.master')

@section('module', 'Giới thiệu công ty')
@section('action', 'Chỉnh sửa mục nội dung')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Chỉnh sửa phần Giới thiệu công ty</h2>
                <p class="text-muted mb-0">Cập nhật nội dung chi tiết cho phần này bên dưới.</p>
            </div>
            <a href="{{ route('admin.company_about.company_profile.index') }}" class="btn btn-primary">
                ← Quay lại danh sách
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
                            <label class="form-label">Mã phần nội dung</label>
                            <input type="text" class="form-control @error('section_key') is-invalid @enderror"
                                name="section_key" value="{{ old('section_key', $profile->section_key) }}" readonly>
                            @error('section_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="col-md-6">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title', $profile->title) }}" placeholder="Nhập tiêu đề cho phần này">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Headline -->
                        <div class="col-md-6">
                            <label class="form-label">Tiêu đề phụ / Dòng nổi bật</label>
                            <input type="text" class="form-control @error('headline') is-invalid @enderror"
                                name="headline" value="{{ old('headline', $profile->headline) }}"
                                placeholder="Nhập tiêu đề phụ hoặc thông điệp nổi bật">
                            @error('headline')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CTA Label -->
                        <div class="col-md-6">
                            <label class="form-label">Nhãn nút kêu gọi (CTA Label)</label>
                            <input type="text" class="form-control @error('cta_label') is-invalid @enderror"
                                name="cta_label" value="{{ old('cta_label', $profile->cta_label) }}"
                                placeholder="Ví dụ: Tìm hiểu thêm, Liên hệ ngay...">
                            @error('cta_label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CTA Link -->
                        <div class="col-md-6">
                            <label class="form-label">Đường dẫn nút (CTA Link)</label>
                            <input type="text" class="form-control @error('cta_link') is-invalid @enderror"
                                name="cta_link" value="{{ old('cta_link', $profile->cta_link) }}"
                                placeholder="Nhập đường dẫn, ví dụ: https://example.com">
                            @error('cta_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Summary -->
                        <div class="col-md-6">
                            <label class="form-label">Tóm tắt nội dung</label>
                            <textarea class="form-control @error('summary') is-invalid @enderror" name="summary" rows="3"
                                placeholder="Nhập phần tóm tắt ngắn gọn, súc tích">{{ old('summary', $profile->summary) }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Body -->
                        <div class="col-12">
                            <label class="form-label">Nội dung chi tiết</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" rows="5"
                                placeholder="Nhập toàn bộ nội dung chi tiết của phần này">{{ old('body', $profile->body) }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Featured Image -->
                        <div class="col-12">
                            <label class="form-label">Ảnh</label>
                            <input type="file" class="form-control @error('featured_image_url') is-invalid @enderror"
                                name="featured_image_url" id="featured_image_url">
                            @error('featured_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 d-flex flex-column align-items-start gap-2">
                                <img id="featuredImagePreview"
                                    src="{{ $profile->featured_image_url ? asset($profile->featured_image_url) : asset('uploads/no_image.jpg') }}"
                                    alt="Ảnh đại diện" class="img-thumbnail"
                                    style="height:80px; width:auto; display: {{ $profile->featured_image_url ? 'block' : asset('uploads/no_image.jpg') }};">

                                <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm"
                                    style="display: {{ $profile->featured_image_url ? 'inline-block' : 'none' }};">
                                    Xoá ảnh
                                </button>
                            </div>
                        </div>

                    </div> <!-- /row -->

                    <!-- Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="submitBtn" style="min-width: 100%">
                                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                                <span class="btn-text">Cập nhật</span>
                            </button>
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" class="btn btn-secondary" id="resetBtn"
                                style="min-width: 100%">Đặt lại</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.company_profile.script')
