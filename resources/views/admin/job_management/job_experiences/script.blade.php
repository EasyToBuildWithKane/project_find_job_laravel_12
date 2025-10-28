@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const table = $('#experience-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.job_experiences.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%', className: 'text-center' }
        ],
        order: [[1, 'asc']]
    });

    $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            text: 'Thao tác này không thể hoàn tác!',
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
                }).then(res => res.json()).then(res => {
                    if (res.success) {
                        Swal.fire('Thành công!', res.message, 'success');
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire('Lỗi!', res.message, 'error');
                    }
                }).catch(() => Swal.fire('Lỗi!', 'Không thể kết nối server.', 'error'));
            }
        });
    });
});
</script>
@endpush
