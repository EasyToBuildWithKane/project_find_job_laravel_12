@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', isset($job) ? 'Chỉnh sửa công việc' : 'Thêm công việc')

@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ isset($job) ? route('admin.jobs.update', $job->id) : route('admin.jobs.store') }}" method="POST">
                @csrf
                @if(isset($job)) @method('PUT') @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" id="title"
                               value="{{ old('title', $job->title ?? '') }}" placeholder="Nhập tiêu đề công việc">
                        @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="company_id" class="form-label">Công ty</label>
                        <select name="company_id" id="company_id" class="form-control">
                            <option value="">Chọn công ty</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" {{ old('company_id', $job->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Các khóa ngoại khác: job_category, job_role, job_type, salary_type, experience, education, city/state/country --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="job_category_id">Danh mục</label>
                        <select name="job_category_id" id="job_category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('job_category_id', $job->job_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('job_category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="job_role_id">Vị trí</label>
                        <select name="job_role_id" id="job_role_id" class="form-control">
                            <option value="">Chọn vị trí</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('job_role_id', $job->job_role_id ?? '') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('job_role_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="job_type_id">Loại công việc</label>
                        <select name="job_type_id" id="job_type_id" class="form-control">
                            <option value="">Chọn loại công việc</option>
                            @foreach($jobTypes as $jt)
                                <option value="{{ $jt->id }}" {{ old('job_type_id', $job->job_type_id ?? '') == $jt->id ? 'selected' : '' }}>{{ $jt->name }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="salary_type_id">Loại lương</label>
                        <select name="salary_type_id" id="salary_type_id" class="form-control">
                            <option value="">Chọn loại lương</option>
                            @foreach($salaryTypes as $st)
                                <option value="{{ $st->id }}" {{ old('salary_type_id', $job->salary_type_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                            @endforeach
                        </select>
                        @error('salary_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="deadline">Hạn nộp</label>
                        <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $job->deadline ?? '') }}">
                        @error('deadline') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description">Mô tả</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description', $job->description ?? '') }}</textarea>
                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success">{{ isset($job) ? 'Cập nhật' : 'Thêm mới' }}</button>
                    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
