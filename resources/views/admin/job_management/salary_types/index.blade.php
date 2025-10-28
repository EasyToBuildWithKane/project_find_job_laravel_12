@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Danh sách loại lương')

@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Danh sách loại lương</h2>
        <a href="{{ route('admin.salary_types.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Thêm mới
        </a>
    </div>

    {{-- Hiển thị alert --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="salaryTypes-table" class="table table-bordered table-striped align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên loại lương</th>
                        <th>Slug</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- Include script riêng --}}
@include('admin.job_management.salary_types.script')
