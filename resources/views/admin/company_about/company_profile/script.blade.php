@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $(function () {

            // -------------------
            // Config / Elements
            // -------------------
            const $form = $('#editProfileForm');
            const $saveBtn = $('#saveBtn');
            const $spinner = $('#btnSpinner');
            const $fileInput = $('#featured_image_url');
            const $preview = $('#preview-featured-image');

            // -------------------
            // Helpers
            // -------------------
            const toggleButtonLoading = (state = true) => {
                $saveBtn.prop('disabled', state);
                $spinner.toggleClass('d-none', !state);
            };

            const showAlert = (icon, title, text, timer = 2000) => {
                Swal.fire({
                    icon, title, html: text,
                    timer, showConfirmButton: !timer
                });
            };

            const resetErrors = () => {
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $('#form-errors').addClass('d-none').empty();
            };

            const showFieldError = ($input, msg) => {
                $input.addClass('is-invalid');
                if ($input.next('.invalid-feedback').length === 0) {
                    $input.after(`<div class="invalid-feedback d-block">${msg}</div>`);
                } else {
                    $input.next('.invalid-feedback').html(msg);
                }
            };

            const showLoadingFields = () => {
                $('#form-fields').html(`
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-spinner fa-spin me-2"></i> Đang tải dữ liệu...
                            </div>
                        `);
            };

            // -------------------
            // DataTable init
            // -------------------
            const table = $('#company-profile-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("admin.company_about.company_profile.index") }}',
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'section_key', name: 'section_key' },
                    { data: 'title', name: 'title' },
                    { data: 'headline', name: 'headline' },
                    { data: 'featured_image_url', name: 'featured_image_url' },
                    { data: 'cta_label', name: 'cta_label' },
                    { data: 'cta_link', name: 'cta_link' },
                    { data: 'actions', orderable: false, searchable: false }
                ]
            });

            // -------------------
            // Open modal edit
            // -------------------
            $(document).on('click', '.btn-edit', function () {
                const sectionKey = $(this).data('section');
                $('#modalSectionKey').val(sectionKey);
                resetErrors();
                showLoadingFields();

                const modalEl = document.getElementById('editProfileModal');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();

                $.get(`/admin/company_about/company_profile/${sectionKey}/edit`, function (res) {
                    $('#form-fields').html(res.html);
                });
            });

            // -------------------
            // Submit form
            // -------------------
            $form.on('submit', function (e) {
                e.preventDefault();
                const sectionKey = $('#modalSectionKey').val();
                const formData = new FormData(this);

                toggleButtonLoading(true);
                resetErrors();

                $.ajax({
                    url: `/admin/company_about/company_profile/${sectionKey}`,
                    method: 'POST', // dùng POST + @method('PUT') trong form
                    data: formData,
                    processData: false,
                    contentType: false,
                }).done(res => {
                    showAlert(res.icon || 'success',
                        res.title || 'Thành công',
                        res.text || 'Cập nhật thành công!');

                    const modal = bootstrap.Modal.getInstance(document.getElementById('editProfileModal'));
                    modal.hide();
                    table.ajax.reload(null, false);
                }).fail(xhr => {
                    const errs = xhr.responseJSON.errors;
                    let list = [];
                    for (const field in errs) {
                        const $input = $form.find(`[name="${field}"]`);
                        if ($input.length) {
                            showFieldError($input, errs[field][0]);
                        } else {
                            $form.prepend(`<div class="alert alert-danger">${errs[field][0]}</div>`);
                        }
                        list.push(errs[field][0]);
                    }
                 showAlert('error', 'Lỗi xác thực từ server', list.join('<br>'));
                }).
                    always(() => {
                        toggleButtonLoading(false);
                    });
            });

            // -------------------
            // Preview featured image
            // -------------------
            $(document).on('change', '#featured_image_url', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        let $preview = $('#preview-featured-image');
                        if ($preview.length === 0) {
                            $fileInput.after(
                                `<div class="mt-2">
                                            <img id="preview-featured-image" src="${e.target.result}" 
                                                 alt="Preview" width="150" class="rounded shadow">
                                        </div>`
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