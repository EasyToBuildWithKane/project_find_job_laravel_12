<h1>Job Experiences</h1>





@extends('admin.layouts.master')
@section('module', 'Quản lý tuyển dụng')
@section('action', 'Danh sách kinh nghiệm làm việc')
@section('admin-content')

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Danh sách kinh nghiệm</h2>
        <a href="{{ route('admin.job_experiences.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Thêm mới</a>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error')) <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="experience-table" class="table table-bordered table-striped w-100 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên kinh nghiệm</th>
                        <th>Slug</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('admin.job_management.job_experiences.script')
@endsection
