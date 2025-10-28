@extends('admin.layouts.master')

@section('module', 'Quốc Gia')
@section('action', 'Chỉnh sửa quốc gia tuyển dụng')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Chỉnh sửa quốc gia tuyển dụng</h2>
            </div>
            <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>


        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="countriesForm"
                      method="POST"
                      action="{{ route('admin.countries.update', $country->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên quốc gia</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $country->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Nhập tên quốc gia">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                                <span class="btn-text">Cập nhật</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.job_management.countries.script')
