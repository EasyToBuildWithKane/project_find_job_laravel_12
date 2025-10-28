@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Danh sách thành phố')

@section('admin-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-1">Danh sách thành phố</h2>
        <a href="{{ route('admin.cities.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Thêm mới
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table id="cities-table" class="table table-bordered table-striped align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên thành phố</th>
                        <th>Tỉnh/Bang</th>
                        <th>Quốc gia</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

{{-- Import script dùng chung cho module City --}}
@include('admin.job_management.cities.script')

