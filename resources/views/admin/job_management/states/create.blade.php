@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Thêm mới tỉnh/bang')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Thêm mới tỉnh/bang</h2>
            </div>
            <a href="{{ route('admin.states.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="statesForm" method="POST"
                      action="{{ route('admin.states.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Tên tỉnh/bang -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên tỉnh/bang <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Nhập tên tỉnh/bang"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quốc gia -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Quốc gia <span class="text-danger">*</span></label>
                            <select class="form-control @error('country_id') is-invalid @enderror"
                                    name="country_id"
                                    required>
                                <option value="">Chọn quốc gia</option>
                                @foreach(\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                                <span class="btn-text">Thêm mới</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.job_management.states.script')


