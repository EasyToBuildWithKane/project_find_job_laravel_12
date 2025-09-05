<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editProfileForm" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="section_key" id="modalSectionKey">

                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileLabel">Chỉnh sửa Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                </div>

                <div class="modal-body">
                    <div id="form-fields" class="mb-3">
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-spinner fa-spin me-2"></i> Đang tải dữ liệu...
                        </div>
                    </div>
                    <div id="form-errors" class="alert alert-danger d-none"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none me-2"></span>
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
