@extends('admin.layouts.master')

@section('module', 'Gói dịch vụ')
@section('action', 'Chỉnh sửa gói')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Chỉnh sửa gói: {{ $plan->name }}</h2>
                <p class="text-muted mb-0">Cập nhật thông tin gói dịch vụ (pricing plan) bên dưới.</p>
            </div>
            <a href="{{ route('admin.pricing.pricing_plan.index') }}" class="btn btn-primary">
                ← Quay lại danh sách
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="pricingPlanForm" method="POST"
                      action="{{ route('admin.pricing.pricing_plan.update', $plan->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        <!-- Slug (readonly) -->
                        <div class="col-md-6">
                            <label class="form-label">Slug (mã định danh)</label>
                            <input type="text"
                                   class="form-control @error('slug') is-invalid @enderror"
                                   name="slug"
                                   value="{{ old('slug', $plan->slug) }}"
                                   readonly>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Slug dùng làm định danh trong URL/API (không sửa nếu đã tồn tại).</small>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label">Tên gói</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name', $plan->name) }}"
                                   placeholder="Nhập tên gói, ví dụ: Gói Pro">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Short description -->
                        <div class="col-12">
                            <label class="form-label">Mô tả ngắn</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror"
                                      name="short_description" rows="3"
                                      placeholder="Mô tả ngắn hiển thị trên UI">{{ old('short_description', $plan->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Is public & Sort order -->
                        <div class="col-md-6">
                            <label class="form-label d-block">Hiển thị</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_public"
                                       name="is_public" value="1"
                                       {{ old('is_public', $plan->is_public) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_public">
                                    Hiển thị gói cho người dùng
                                </label>
                            </div>
                            @error('is_public')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Thứ tự (sort order)</label>
                            <input type="number"
                                   class="form-control @error('sort_order') is-invalid @enderror"
                                   name="sort_order"
                                   value="{{ old('sort_order', $plan->sort_order ?? 0) }}"
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Số nhỏ sẽ hiển thị trước.</small>
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
                            <button type="button" class="btn btn-secondary" id="resetBtn" style="min-width: 100%">
                                Đặt lại
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('pricingPlanForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const resetBtn = document.getElementById('resetBtn');

        // Show spinner on submit and disable button to prevent double submit
        form.addEventListener('submit', function () {
            submitSpinner.classList.remove('d-none');
            submitBtn.setAttribute('disabled', 'disabled');
        });

        // Reset button restores original values from server-rendered page
        resetBtn.addEventListener('click', function () {
            // Reset inputs to initial values rendered by server (old() handling is server-side)
            // Simplest approach: reload the page to restore original values
            if (confirm('Bạn có muốn đặt lại form về giá trị ban đầu?')) {
                window.location.reload();
            }
        });
    });
</script>
@endpush
