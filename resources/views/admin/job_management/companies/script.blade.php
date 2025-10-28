@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableEl = $('#companies-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.companies.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
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
            emptyTable: "Không có dữ liệu công ty",
            search: "Tìm kiếm:",
            lengthMenu: "Hiển thị _MENU_ dòng",
            info: "Hiển thị _START_ đến _END_ trong _TOTAL_ dòng",
            infoEmpty: "Không có dữ liệu",
            zeroRecords: "Không tìm thấy kết quả phù hợp",
            paginate: { previous: "‹", next: "›" }
        }
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        const url = $(this).data('url');

        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            text: 'Hành động này không thể hoàn tác!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy'
        }).then(result => {
            if(result.isConfirmed){
                fetch(url, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}','Accept':'application/json'}
                })
                .then(res => res.json())
                .then(res => {
                    if(res.success){
                        Swal.fire('Thành công!', res.message, 'success');
                        tableEl.ajax.reload(null, false);
                    } else {
                        Swal.fire('Thất bại!', res.message || 'Không thể xóa.', 'error');
                    }
                })
                .catch(() => Swal.fire('Lỗi!', 'Không thể kết nối server.', 'error'));
            }
        });
    });
});
</script>
@endpush
