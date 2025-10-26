@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa loại lương')

@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.salary_types.update', $salaryType->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Tên loại lương</label>
                    <input type="text" name="name" class="form-control" id="name"
                           value="{{ old('name', $salaryType->name) }}" placeholder="Nhập tên loại lương">
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.salary_types.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection
