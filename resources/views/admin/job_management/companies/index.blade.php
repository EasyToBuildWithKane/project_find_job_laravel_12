@extends('admin.layouts.master')
@section('module','Quản lý tuyển dụng')
@section('action','Danh sách công ty')

@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Danh sách công ty</h2>
        <a href="{{ route('admin.companies.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Thêm mới</a>
    </div>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> 
    @elseif(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="companies-table" class="table table-bordered table-striped w-100">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên công ty</th>
                        <th>Người dùng</th>
                        <th>Ngành</th>
                        <th>Loại tổ chức</th>
                        <th>Quy mô</th>
                        <th>Thành phố</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('admin.job_management.companies.script')
@endsection
 