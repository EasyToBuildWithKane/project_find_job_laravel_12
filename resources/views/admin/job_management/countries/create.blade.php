@extends('admin.layouts.master')

@section('module', 'Công Ty')
@section('action', 'Thêm mới công ty tuyển dụng')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Thêm mới quốc gia tuyển dụng </h2>
            </div>
            <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="countriesForm" method="POST"
                      action="{{ route('admin.countries.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Họ và tên -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tên quóc gia</label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   placeholder="Nhập tên quốc gia">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       
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

