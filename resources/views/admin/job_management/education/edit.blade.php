@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa trình độ')
@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.education.update', $education->id) }}" method="POST" id="educationForm">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên trình độ</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $education->name) }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn"><span class="btn-text">Cập nhật</span></button>
                <a href="{{ route('admin.education.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection
