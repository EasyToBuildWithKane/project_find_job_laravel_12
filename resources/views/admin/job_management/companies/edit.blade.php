@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa công ty')

@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tên công ty</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}">
                    @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}">
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}">
                    @error('phone')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo" class="form-control">
                    @if($company->logo)
                        <img src="{{ asset('storage/'.$company->logo) }}" alt="logo" width="80" class="mt-2">
                    @endif
                    @error('logo')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner</label>
                    <input type="file" name="banner" class="form-control">
                    @if($company->banner)
                        <img src="{{ asset('storage/'.$company->banner) }}" alt="banner" width="150" class="mt-2">
                    @endif
                    @error('banner')<span class="text-danger small">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection
