<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <form id="editProfileForm" novalidate enctype="multipart/form-data" >
                @csrf
                @method('PUT')
                <input type="hidden" name="section_key" id="modalSectionKey">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editProfileLabel">Chỉnh sửa Section</h5>
                    <button type="button" class="close btn-close-white" id="btnCloseModal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="form-fields" class="mb-3"></div>
                    <div id="form-errors" class="alert alert-danger d-none"></div>
                </div>

                <div class="modal-footer">
                  
                    </button> <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="spinner-border spinner-border-sm d-none me-2" id="btnSpinner"></span>
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    function closeModal() {
        const modal = document.getElementById('editProfileModal');

    modal.classList.remove('show');
        modal.style.display = 'none';

        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('padding-right');
    }

    document.getElementById('btnCloseModal').addEventListener('click', closeModal);
    closeModal
</script>