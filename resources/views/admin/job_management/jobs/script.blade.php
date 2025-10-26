@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // DataTable
    const table = $('#jobs-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.jobs.index") }}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width:'5%'},
            {data: 'title', name: 'title'},
            {data: 'company', name: 'company.name'},
            {data: 'category', name: 'category.name'},
            {data: 'role', name: 'role.name'},
            {data: 'job_type', name: 'jobType.name'},
            {data: 'salary_type', name: 'salaryType.name'},
            {data: 'deadline', name: 'deadline'},
            {data: 'status', name: 'status'},
            {data: 'action', name:'action', orderable:false, searchable:false}
        ],
        order: [[1,'asc']],
        language: { emptyTable: "Không có dữ liệu" }
    });

    // Xóa record
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        const url = $(this).data('url');
        if(!url) return Swal.fire('Lỗi!', 'Không tìm thấy đường dẫn xóa', 'error');

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
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if(res.success){
                        Swal.fire('Thành công!', res.message, 'success');
                        table.ajax.reload(null,false);
                    } else {
                        Swal.fire('Thất bại!', res.message || 'Không thể xóa', 'error');
                    }
                })
                .catch(() => Swal.fire('Lỗi!', 'Không thể kết nối server', 'error'));
            }
        });
    });

});
</script>
@endpush
