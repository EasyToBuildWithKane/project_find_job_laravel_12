@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /** =====================================
     *  1️⃣ SweetAlert helper
     * ===================================== */
    const showSwal = (icon, title, text) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: 2000,
            showConfirmButton: false
        });
    };

    @if (session('success'))
        showSwal('success', 'Thành công', '{{ session('success') }}');
    @endif

    @if (session('error'))
        showSwal('error', 'Thất bại', '{{ session('error') }}');
    @endif


    /** =====================================
     *  2️⃣ Hiển thị loading khi submit form
     * ===================================== */
    const form = document.getElementById('salaryTypeForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');

    if (form && submitBtn) {
        form.addEventListener('submit', () => {
            if (submitSpinner) submitSpinner.classList.remove('d-none');
            const btnText = submitBtn.querySelector('.btn-text');
            if (btnText) btnText.textContent = 'Đang xử lý...';
            submitBtn.disabled = true;
        });
    }


    /** =====================================
     *  3️⃣ DataTable hiển thị danh sách
     * ===================================== */
    const tableEl = document.getElementById('salaryTypes-table');
    if (tableEl) {
        const table = $('#salaryTypes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.salary_types.index") }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                { data: 'name', name: 'name' },
                { data: 'slug', name: 'slug' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '15%'
                }
            ],
            order: [[1, 'asc']],
            language: {
                processing: "Đang tải dữ liệu...",
                emptyTable: "Không có dữ liệu loại lương",
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ dòng",
                info: "Hiển thị _START_ đến _END_ trong _TOTAL_ dòng",
                infoEmpty: "Không có dữ liệu",
                zeroRecords: "Không tìm thấy kết quả phù hợp",
                paginate: { previous: "‹", next: "›" }
            }
        });


        /** =====================================
         *  4️⃣ Xoá loại lương
         * ===================================== */
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const url = $(this).data('url');

            if (!url) {
                return Swal.fire('Lỗi!', 'Không tìm thấy đường dẫn xoá.', 'error');
            }

            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire('Thành công!', res.message, 'success');
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire('Thất bại!', res.message || 'Không thể xóa.', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Lỗi!', 'Không thể kết nối server.', 'error'));
                }
            });
        });
    }

});
</script>
@endpush
