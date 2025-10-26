@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa danh mục')
@section('admin-content')

<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.job_categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $category->icon) }}">
                    @error('icon') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="show_at_featured" id="show_at_featured" value="1" {{ old('show_at_featured', $category->show_at_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_at_featured">Hiển thị nổi bật</label>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" name="show_at_popular" id="show_at_popular" value="1" {{ old('show_at_popular', $category->show_at_popular) ? 'checked' : '' }}>
                    <label class="form-check-label" for="show_at_popular">Hiển thị phổ biến</label>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href=
