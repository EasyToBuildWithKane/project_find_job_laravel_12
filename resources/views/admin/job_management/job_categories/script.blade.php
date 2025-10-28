@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const table = $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.job_categories.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'icon', name: 'icon' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'show_at_featured', name: 'show_at_featured', render: data => data ? '✅' : '❌', className: 'text-center' },
            { data: 'show_at_popular', name: 'show_at_popular', render: data => data ? '✅' : '❌', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[2, 'asc']]
    });

    $(document).on('click', '.btn-delete', function () {
        const url = $(this).data('url');
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
