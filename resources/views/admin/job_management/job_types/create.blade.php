@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Thêm loại công việc')
@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.job_types.store') }}" method="POST" id="jobTypeForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên loại công việc</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-success" id="submitBtn"><span class="btn-text">Lưu</span></button>
                <a href="{{ route('admin.job_types.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
