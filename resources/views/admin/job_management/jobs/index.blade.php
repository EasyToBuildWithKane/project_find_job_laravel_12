@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Danh sách công việc')

@section('admin-content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Danh sách công việc</h2>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Thêm mới
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="jobs-table" class="table table-bordered table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề</th>
                        <th>Công ty</th>
                        <th>Danh mục</th>
                        <th>Vị trí</th>
                        <th>Loại công việc</th>
                        <th>Loại lương</th>
                        <th>Hạn nộp</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

{{-- Include riêng file script --}}
@include('admin.job_management.jobs.script')
@endsection
