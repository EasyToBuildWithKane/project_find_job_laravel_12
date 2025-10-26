@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Chỉnh sửa công việc')

@section('admin-content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" id="jobForm">
                @csrf
                @method('PUT')

                {{-- Company --}}
                <div class="mb-3">
                    <label for="company_id" class="form-label">Công ty</label>
                    <select name="company_id" class="form-select">
                        <option value="">-- Chọn công ty --</option>
                        @foreach($companies ?? [] as $company)
                            <option value="{{ $company->id }}" {{ $job->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Title --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}">
                    @error('title') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Category --}}
                <div class="mb-3">
                    <label for="job_category_id" class="form-label">Danh mục</label>
                    <select name="job_category_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->id }}" {{ $job->job_category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('job_category_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Job Type --}}
                <div class="mb-3">
                    <label for="job_type_id" class="form-label">Loại công việc</label>
                    <select name="job_type_id" class="form-select">
                        <option value="">-- Chọn loại --</option>
                        @foreach($jobTypes ?? [] as $type)
                            <option value="{{ $type->id }}" {{ $job->job_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('job_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Salary Type --}}
                <div class="mb-3">
                    <label for="salary_type_id" class="form-label">Loại lương</label>
                    <select name="salary_type_id" class="form-select">
                        <option value="">-- Chọn loại lương --</option>
                        @foreach($salaryTypes ?? [] as $salary)
                            <option value="{{ $salary->id }}" {{ $job->salary_type_id == $salary->id ? 'selected' : '' }}>{{ $salary->name }}</option>
                        @endforeach
                    </select>
                    @error('salary_type_id') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Vacancies --}}
                <div class="mb-3">
                    <label for="vacancies" class="form-label">Số lượng tuyển</label>
                    <input type="text" name="vacancies" class="form-control" value="{{ old('vacancies', $job->vacancies) }}">
                    @error('vacancies') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Salary Range --}}
                <div class="row mb-3">
                    <div class="col">
                        <label for="min_salary" class="form-label">Lương tối thiểu</label>
                        <input type="text" name="min_salary" class="form-control" value="{{ old('min_salary', $job->min_salary) }}">
                        @error('min_salary') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="col">
                        <label for="max_salary" class="form-label">Lương tối đa</label>
                        <input type="text" name="max_salary" class="form-control" value="{{ old('max_salary', $job->max_salary) }}">
                        @error('max_salary') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả công việc</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $job->description) }}</textarea>
                    @error('description') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Deadline --}}
                <div class="mb-3">
                    <label for="deadline" class="form-label">Hạn nộp hồ sơ</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline) }}">
                    @error('deadline') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ old('status', $job->status)=='pending' ? 'selected':'' }}>Chờ duyệt</option>
                        <option value="active" {{ old('status', $job->status)=='active' ? 'selected':'' }}>Đang hoạt động</option>
                        <option value="expired" {{ old('status', $job->status)=='expired' ? 'selected':'' }}>Hết hạn</option>
                    </select>
                    @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div>
@endsection
