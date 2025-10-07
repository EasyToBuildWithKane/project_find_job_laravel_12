@extends('admin.layouts.master')

@section('module', 'Giới thiệu công ty')
@section('action', 'Quản lý lý do chọn chúng tôi')

@section('admin-content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="section-title mb-1">Quản lý mục "Vì sao chọn chúng tôi"</h2>
                <p class="text-muted mb-0">
                    Tại đây bạn có thể xem, thêm mới hoặc chỉnh sửa các lý do mà khách hàng nên chọn công ty.
                </p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-light">
                <h4 class="mb-0 fw-semibold">Danh sách lý do chọn chúng tôi</h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="why-choose-us-table" class="table table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">ID</th>
                                <th>Tiêu đề mục</th>
                                <th>Phụ đề phần</th>
                                <th>Mô tả</th>
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
        $(function() {

            // ===== Hàm hiển thị thông báo SweetAlert =====
            const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };

            // ===== Flash message từ session =====
            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif

            // ===== Khởi tạo DataTable =====
            $('#why-choose-us-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.company_about.why_choose_us.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'item_title',
                        name: 'item_title'
                    },
                    {
                        data: 'section_subtitle',
                        name: 'section_subtitle'
                    },

                    {
                        data: 'item_description',
                        name: 'item_description',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">Không có mô tả</span>';
                            return data.length > 80 ?
                                data.substring(0, 80) + '...' :
                                data;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
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
