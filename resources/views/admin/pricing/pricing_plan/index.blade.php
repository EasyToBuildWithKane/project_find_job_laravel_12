@extends('admin.layouts.master')

@section('module', 'Pricing Plans')
@section('action', 'Quản lý các gói giá')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Quản lý Pricing Plans</h2>
                <p class="text-muted mb-0">
                    Tại đây bạn có thể xem, chỉnh sửa hoặc xóa các gói pricing.
                </p>
            </div>

            <div>
                <a href="{{ route('admin.pricing.pricing_plan.create') }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Thêm gói mới
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h4 class="mb-0 fw-semibold">Danh sách pricing plans</h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="pricing-plans-table" class="table table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Slug</th>
                                <th>Tên gói</th>
                                <th>Mô tả ngắn</th>
                                <th>Trạng thái</th>
                                <th>Thứ tự</th>
                                <th width="14%">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

    <script>
        $(function () {
            // SweetAlert flash
            const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };

            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showSwal('error', 'Lỗi', '{{ session('error') }}');
            @endif

            // Initialize DataTable
            $('#pricing-plans-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.pricing.pricing_plan.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'slug', name: 'slug' },
                    { data: 'name', name: 'name' },
                    { data: 'short_description', name: 'short_description', orderable: false, searchable: true },
                    { data: 'is_public', name: 'is_public', orderable: false, searchable: false },
                    { data: 'sort_order', name: 'sort_order' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [[0, 'asc']],
                dom:
                    "<'d-flex justify-content-between align-items-center mb-3'f'l>" +
                    "rt" +
                    "<'d-flex justify-content-between align-items-center mt-3'p i>",
                responsive: true,
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    info: "Hiển thị _START_ - _END_ / _TOTAL_ bản ghi",
                    infoEmpty: "Không có dữ liệu",
                    zeroRecords: "Không tìm thấy kết quả phù hợp",
                    paginate: {
                        previous: "«",
                        next: "»"
                    }
                }
            });
        });
    </script>
@endpush