@extends('admin.layouts.master')

@section('module', 'Công ty của chúng tôi')
@section('action', 'Chỉnh sửa - Lý do chọn chúng tôi')

@section('admin-content')
    <div class="container-fluid">
        {{-- ======= Header ======= --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Chỉnh sửa mục "Lý do chọn chúng tôi"</h2>
                <p class="text-muted mb-0">Vui lòng cập nhật thông tin chi tiết của phần này bên dưới.</p>
            </div>
            <a href="{{ route('admin.company_about.why_choose_us.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
        </div>

        {{-- ======= Form Card ======= --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="whyChooseUsForm" method="POST"
                    action="{{ route('admin.company_about.why_choose_us.update', $item->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Tiêu đề phần --}}
                        {{-- <div class="col-md-6">
                            <label class="form-label fw-semibold">Tiêu đề phần</label>
                            <input type="text" name="section_title"
                                class="form-control @error('section_title') is-invalid @enderror"
                                value="{{ old('section_title', $item->section_title) }}"
                                placeholder="VD: Vì sao chọn chúng tôi">
                            @error('section_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}
                        {{-- Tiêu đề mục  --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tiêu đề mục</label>
                            <input type="text" name="item_title"
                                class="form-control @error('item_title') is-invalid @enderror"
                                value="{{ old('item_title', $item->item_title) }}" placeholder="VD: Chi phí hợp lý">
                            @error('item_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Phụ đề phần --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phụ đề phần</label>
                            <input type="text" name="section_subtitle"
                                class="form-control @error('section_subtitle') is-invalid @enderror"
                                value="{{ old('section_subtitle', $item->section_subtitle) }}"
                                placeholder="VD: Nơi bạn tìm thấy ứng viên lý tưởng...">
                            @error('section_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- Mô tả mục con --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Mô tả chi tiết</label>
                            <textarea name="item_description" class="form-control @error('item_description') is-invalid @enderror"
                                placeholder="Nhập mô tả ngắn cho mục này..." rows="4">{{ old('item_description', $item->item_description) }}</textarea>
                            @error('item_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- ======= Actions ======= --}}
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end gap-3">
                            <button type="submit" id="submitBtn" class="btn btn-primary px-4 d-flex align-items-center">
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="submitSpinner"></span>
                                <span class="btn-text">Cập nhật</span>
                            </button>
                            <button type="button" class="btn btn-secondary px-4" id="resetBtn">Đặt lại</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.why_choose_us.script')
