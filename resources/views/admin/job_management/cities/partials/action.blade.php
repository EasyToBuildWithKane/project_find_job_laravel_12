<div class="btn-group" role="group">
    <a href="{{ route('admin.cities.edit', $row->id) }}" 
       class="btn btn-sm btn-warning text-white">
        <i class="fas fa-edit"></i>
    </a>

    <button type="button"
        class="btn btn-sm btn-danger btn-delete"
        data-url="{{ route('admin.cities.destroy', $row->id) }}">
        <i class="fas fa-trash"></i>
    </button>
</div>

@pushOnce('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('click', function(e) {
    // Kiểm tra nếu phần tử click là nút xóa hoặc chứa nút xóa
    const btn = e.target.closest('.btn-delete');
    if (!btn) return; // Nếu không phải thì bỏ qua
    e.preventDefault();

    const form = btn.closest('form');
    if (!form) return;

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
@endPushOnce
