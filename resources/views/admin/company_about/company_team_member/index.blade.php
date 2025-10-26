@extends('admin.layouts.master')

@section('module', 'Giới thiệu công ty')
@section('action', 'Quản lý thành viên')

@section('admin-content')
    <div class="container-fluid">
        <h2 class="section-title">Danh sách thành viên công ty</h2>
        <p class="section-lead">
            Quản lý toàn bộ thành viên trong công ty tại đây. Bạn có thể chỉnh sửa hoặc ẩn/hiện từng người.
        </p>

        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Danh sách thành viên</h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="team-member-table" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Họ và tên</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Vị trí</th>
                                <th>Ảnh đại diện</th>
                                <th>Hiển thị nổi bật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    <script>
        $(document).ready(function() {
            // ===== Helper: Hiển thị thông báo SweetAlert =====
            const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };

            // ===== Hiển thị thông báo Flash từ session =====
            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif
            @if (session('error'))
                showSwal('error', 'Thất bại', '{{ session('error') }}');
            @endif

            // ===== Khởi tạo DataTables =====
            const table = $('#team-member-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.company_about.company_team_member.index') }}',
                    type: 'GET',
                    error: function(xhr) {
                        showSwal('error', 'Lỗi tải dữ liệu',
                            'Không thể tải danh sách thành viên, vui lòng thử lại sau.');
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'job_title',
                        name: 'job_title'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'profile_image_url',
                        name: 'profile_image_url',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured'
                       
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [
                    [0, 'asc']
                ],
                dom: "<'d-flex justify-content-between align-items-center mb-3'f'l>" +
                    "rt" +
                    "<'d-flex justify-content-between align-items-center mt-3'p i>",
                responsive: true,
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    zeroRecords: "Không tìm thấy kết quả phù hợp",
                    info: "Trang _PAGE_ / _PAGES_",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(lọc từ _MAX_ dòng)"
                }
            });
        });
    </script>
@endpush
