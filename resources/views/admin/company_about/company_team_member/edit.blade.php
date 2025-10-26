@extends('admin.layouts.master')

@section('module', 'Công Ty')
@section('action', 'Chỉnh Sửa Thành Viên Đội Ngũ')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">Chỉnh sửa thành viên đội ngũ</h2>
                <p class="text-muted mb-0">Cập nhật thông tin chi tiết của thành viên bên dưới.</p>
            </div>
            <a href="{{ route('admin.company_about.company_team_member.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form id="teamMemberForm" method="POST"
                      action="{{ route('admin.company_about.company_team_member.update', $member->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Họ và tên -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Họ và tên</label>
                            <input type="text"
                                   class="form-control @error('full_name') is-invalid @enderror"
                                   name="full_name"
                                   value="{{ old('full_name', $member->full_name) }}"
                                   placeholder="Nhập họ và tên đầy đủ">
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Chức vụ -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Chức vụ</label>
                            <input type="text"
                                   class="form-control @error('job_title') is-invalid @enderror"
                                   name="job_title"
                                   value="{{ old('job_title', $member->job_title) }}"
                                   placeholder="VD: Trưởng phòng Marketing">
                            @error('job_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phòng ban -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phòng ban</label>
                            <input type="text"
                                   class="form-control @error('department') is-invalid @enderror"
                                   name="department"
                                   value="{{ old('department', $member->department) }}"
                                   placeholder="VD: Bộ phận Kinh doanh">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Vị trí làm việc -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vị trí làm việc</label>
                            <input type="text"
                                   class="form-control @error('location') is-invalid @enderror"
                                   name="location"
                                   value="{{ old('location', $member->location) }}"
                                   placeholder="VD: TP. Hồ Chí Minh">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nổi bật -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold d-block">Hiển thị nổi bật</label>
                            <select name="is_featured" id="is_featured"
                                    class="form-control selectric @error('is_featured') is-invalid @enderror">
                                <option value="1" {{ old('is_featured', $member->is_featured) ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ !old('is_featured', $member->is_featured) ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            @error('is_featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ảnh đại diện -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Ảnh đại diện</label>
                            <input type="file"
                                   class="form-control @error('profile_image_url') is-invalid @enderror"
                                   name="profile_image_url" id="profile_image_url" accept="image/*">
                            @error('profile_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3 d-flex flex-column align-items-start gap-2">
                                <img id="profileImagePreview"
                                     src="{{ $member->profile_image_url ? asset($member->profile_image_url) : asset('uploads/no_image.jpg') }}"
                                     alt="Ảnh đại diện"
                                     class="img-thumbnail shadow-sm rounded-circle"
                                     style="height:100px; width:100px; object-fit:cover;">

                                <button type="button" id="removeImageBtn" class="btn btn-outline-danger btn-sm"
                                        style="display: {{ $member->profile_image_url ? 'inline-block' : 'none' }};">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa ảnh
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="submitSpinner"></span>
                                <span class="btn-text">Cập nhật</span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-outline-secondary w-100" id="resetBtn">
                                <i class="fas fa-undo me-1"></i> Đặt lại
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.company_team_member.script')
