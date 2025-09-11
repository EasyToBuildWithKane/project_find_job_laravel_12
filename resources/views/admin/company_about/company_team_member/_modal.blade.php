<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow-lg">
            <form id="editMemberForm" novalidate  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="modalMemberId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Chỉnh sửa Team Member</h5>
                    <button type="button" class="close btn-close-white" data-bs-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="form-fields"></div>
                    <div id="form-errors" class="alert alert-danger d-none"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <span class="spinner-border spinner-border-sm d-none me-2" id="btnSpinner"></span>
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
