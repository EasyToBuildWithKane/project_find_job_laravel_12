@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa vị trí')
@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.job_roles.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên vị trí</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.job_roles.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
