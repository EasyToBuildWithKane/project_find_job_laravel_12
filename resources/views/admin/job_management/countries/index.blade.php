@extends('admin.layouts.master')

@section('module', 'Quản lý tuyển dụng')
@section('action', 'Quản lý các phần nội dung')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Quản lý các quốc gia tuyển dụng của công ty</h2>
                <p class="text-muted mb-0">
                    Tại đây bạn có thể xem và chỉnh sửa nội dung từng phần của Quản lý các quốc gia tuyển dụng của công ty .
                </p>
            </div>

            {{-- Nút thêm quốc gia --}}
            <div>
                <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Thêm quốc gia
                </a>
            </div>
        </div>


        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h4 class="mb-0 fw-semibold">
                    Danh sách các phần
                </h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="countries-table" class="table table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tên Quốc Gia</th>
                                <th width="10%">Thao tác</th>
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
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

    <script>
        $(function () {

            // ===== Hàm thông báo ngắn gọn bằng SweetAlert =====
            const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };

            // ===== Hiển thị thông báo flash từ session =====
            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif

            // ===== Khởi tạo DataTable =====
            $('#countries-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.countries.index') }}',
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        orderable: true,
                    },
                    { data: 'name', name: 'name' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
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


