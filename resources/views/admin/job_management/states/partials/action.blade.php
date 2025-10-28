<a href="{{ route('admin.states.edit', $row->id) }}" 
   class="btn btn-sm btn-primary me-1">
    <i class="fas fa-edit"></i> Sửa
</a>

<form action="{{ route('admin.states.destroy', $row->id) }}" 
      method="POST" 
      class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger btn-delete">
        <i class="fas fa-trash"></i> Xóa
    </button>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return; // không phải nút xóa
    e.preventDefault();

    const form = btn.closest('form');

    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Hành động này không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then(result => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});
</script>


