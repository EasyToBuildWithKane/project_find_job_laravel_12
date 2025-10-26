@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Thêm mới thành phố')

@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Thêm mới thành phố</h2>
        <a href="{{ route('admin.cities.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form id="citiesForm"
                  method="POST"
                  action="{{ route('admin.cities.store') }}">
                @csrf

                <div class="row g-4">
                    <!-- Tên thành phố -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tên thành phố <span class="text-danger">*</span></label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Nhập tên thành phố"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Quốc gia -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Quốc gia <span class="text-danger">*</span></label>
                        <select name="country_id"
                                id="countrySelect"
                                class="form-control @error('country_id') is-invalid @enderror"
                                required>
                            <option value="">Chọn quốc gia</option>
                            @foreach(\App\Models\Country::orderBy('name')->get() as $country)
                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tỉnh/Bang -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tỉnh/Bang <span class="text-danger">*</span></label>
                        <select class="form-control @error('state_id') is-invalid @enderror"
                                name="state_id"
                                id="stateSelect"
                                required>
                            <option value="">Chọn tỉnh/bang</option>
                            @foreach(\App\Models\State::orderBy('name')->get() as $state)
                                <option value="{{ $state->id }}"
                                        data-country="{{ $state->country_id }}"
                                        {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                    {{ $state->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Nút thêm -->
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

@include('admin.job_management.cities.script')
