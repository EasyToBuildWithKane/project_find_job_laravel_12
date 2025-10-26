@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Thêm công ty')

@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Tên công ty</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                    @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @error('logo')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner</label>
                    <input type="file" name="banner" class="form-control">
                    @error('banner')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
