@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Thêm trình độ')
@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.education.store') }}" method="POST" id="educationForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên trình độ</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-success" id="submitBtn"><span class="btn-text">Lưu</span></button>
                <a href="{{ route('admin.education.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
