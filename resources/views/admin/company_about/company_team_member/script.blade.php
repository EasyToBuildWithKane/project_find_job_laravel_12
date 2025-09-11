@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $(function () {
            const $form = $('#editMemberForm');
            const $saveBtn = $('#saveBtn');
            const $spinner = $('#btnSpinner');

            const toggleButtonLoading = (state = true) => {
                $saveBtn.prop('disabled', state);
                $spinner.toggleClass('d-none', !state);
            };

            const showAlert = (icon, title, text, timer = 2000) => {
                Swal.fire({ icon, title, html: text, timer, showConfirmButton: !timer });
            };

            const resetErrors = () => {
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $('#form-errors').addClass('d-none').empty();
            };

            const table = $('#company-team-member-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.company_about.company_team_member.index") }}',
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'job_title', name: 'job_title' },
                    { data: 'department', name: 'department' },
                    { data: 'location', name: 'location' },
                    { data: 'profile_image_url', name: 'profile_image_url' },
                    { data: 'rating', name: 'rating' },
                    { data: 'review_count', name: 'review_count' },
                    { data: 'is_featured', name: 'is_featured' },
                    { data: 'display_order', name: 'display_order' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            // Khi bấm nút edit
            $(document).on('click', '.btn-edit', function () {
                const url = $(this).data('url');
                $.get(url, function (res) {
                    $('#form-fields').html(res.html);
                    $('#modalMemberId').val(res.id); 
                    $('#editMemberModal').modal('show');
                }).fail(function (xhr) {
                    console.error("Lỗi khi load form edit:", xhr.responseText);
                    showAlert('error', 'Lỗi', 'Không thể tải dữ liệu thành viên');
                });
            });

            // Submit form
            $form.on('submit', function (e) {
                e.preventDefault();
                const id = $('#modalMemberId').val();
                const formData = new FormData(this);
                formData.append('_method', 'PUT'); 
                toggleButtonLoading(true);
                resetErrors();

                $.ajax({
                    url: `/admin/company_about/company_team_member/${id}`,
                    method: 'POST', // dùng POST + @method('PUT') trong form
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(res => {
                    showAlert('success', 'Thành công', res.message);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editMemberModal'));
                    modal.hide();
                    table.ajax.reload(null, false);
                }).fail(xhr => {
                    const errs = xhr.responseJSON?.errors || {};
                    let list = [];
                    for (const field in errs) {
                        const $input = $form.find(`[name="${field}"]`);
                        if ($input.length) {
                            $input.addClass('is-invalid')
                                .after(`<div class="invalid-feedback d-block">${errs[field][0]}</div>`);
                        }
                        list.push(errs[field][0]);
                    }
                    showAlert('error', 'Lỗi xác thực', list.join('<br>'));
                }).always(() => {
                    toggleButtonLoading(false);
                });
            });

            // Preview ảnh
            $(document).on('change', '#profile_image_url', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        let $preview = $('#preview-profile-image');
                        if ($preview.length === 0) {
                            $('#profile_image_url').after(
                                `<div class="mt-2"><img id="preview-profile-image" src="${e.target.result}" width="100" class="rounded shadow"></div>`
                            );
                        } else {
                            $preview.attr('src', e.target.result);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush