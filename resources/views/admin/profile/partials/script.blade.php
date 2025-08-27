@push('scripts')
<script>
    $(function() {
        // -------------------
        // Config / Elements
        // -------------------
        const defaultAvatar = '{{ asset('uploads/no_image.jpg') }}';

        const $form = $('#profileForm');
        const $btn = $form.find('button[type=submit]');
        const $spinner = $btn.find('.spinner-border');
        const $btnText = $btn.find('.btn-text');
        const $dz = $('#avatarDropzone');
        const $file = $('#image');
        const $previewForm = $('#showImage');
        const $profileAvatar = $('#profileAvatar');
        const $removeBtn = $('#removeImageBtn');
        const $nameInput = $('#nameInput');
        const $phoneInput = $('#phoneInput');
        const $socialInput = $('#linkSocialInput');

        // -------------------
        // Helpers (UI)
        // -------------------
        const showAlert = (icon, title, text, timer = null) => {
            Swal.fire({
                icon,
                title,
                html: text,
                timer,
                showConfirmButton: !timer
            });
        };

        const setButtonLoading = (state) => {
            $btn.prop('disabled', state);
            $spinner.toggleClass('d-none', !state);
            $btnText.text(state ? 'Đang lưu...' : 'Lưu thay đổi');
        };

        const applyWidgetData = (data) => {
            if (!data) return;
            $profileAvatar.attr('src', data.avatar_url || defaultAvatar);
            $('#profileName').text(data.username);
            $('#profilePhone').text(data.phone || '-');
            if (data.link_social) {
                $('#profileSocial').text(data.link_social).attr('href', data.link_social);
            } else {
                $('#profileSocial').text('No social link').removeAttr('href');
            }
        };

        const clearValidation = () => {
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').remove();
        };

        // inline field error helpers
        const showFieldError = ($input, msg) => {
            $input.addClass('is-invalid');
            if ($input.next('.invalid-feedback').length === 0) {
                $input.after(`<div class="invalid-feedback d-block">${msg}</div>`);
            } else {
                $input.next('.invalid-feedback').html(msg);
            }
        };
        const clearFieldError = ($input) => {
            $input.removeClass('is-invalid');
            $input.next('.invalid-feedback').remove();
        };

        // -------------------
        // Validation rules (client-side)
        // -------------------
        const isValidName = (name) => {
            name = (name || '').trim();
            if (!name) return { ok: false, msg: 'Tên không được để trống.' };
            if (name.length < 2) return { ok: false, msg: 'Tên phải có ít nhất 2 ký tự.' };
            if (name.length > 100) return { ok: false, msg: 'Tên không được quá 100 ký tự.' };
            // Unicode letters, combining marks, spaces, dot, hyphen, apostrophe allowed
            const re = /^[\p{L}\p{M}\s.'\-]+$/u;
            if (!re.test(name)) return { ok: false, msg: 'Tên chứa ký tự không hợp lệ.' };
            return { ok: true };
        };

        const isValidPhone = (phone) => {
            if (!phone) return { ok: true }; // phone optional
            const digits = phone.replace(/\D/g, '');
            if (digits.length !== 10) return { ok: false, msg: 'Số điện thoại phải gồm 10 chữ số (ví dụ 0912345678).' };
            if (!/^0\d{9}$/.test(digits)) return { ok: false, msg: 'Số điện thoại không hợp lệ.' };
            return { ok: true };
        };

        const normalizeAndValidateUrl = (url) => {
            if (!url) return { ok: true, normalized: '' };
            url = url.trim();
            if (!/^https?:\/\//i.test(url)) url = 'https://' + url;
            try {
                const u = new URL(url);
                if (!['http:', 'https:'].includes(u.protocol)) {
                    return { ok: false, msg: 'Đường dẫn phải bắt đầu bằng http:// hoặc https://.' };
                }
                return { ok: true, normalized: u.href };
            } catch (e) {
                return { ok: false, msg: 'Đường dẫn không hợp lệ.' };
            }
        };

        const validateImageFile = (file) => {
            if (!file) return { ok: true };
            const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            const maxBytes = 2 * 1024 * 1024; // 2MB
            if (!validTypes.includes(file.type)) return { ok: false, msg: 'Vui lòng tải ảnh JPG/PNG/WEBP/GIF.' };
            if (file.size > maxBytes) return { ok: false, msg: 'Kích thước ảnh không được vượt quá 2MB.' };
            return { ok: true };
        };

        // -------------------
        // Avatar Preview & File handling (uses validation above)
        // -------------------
        function handleFile(file) {
            const v = validateImageFile(file);
            if (!v.ok) {
                showAlert('error', 'Tệp không hợp lệ', v.msg);
                // reset file input safely
                $file.val('');
                return;
            }

            const url = URL.createObjectURL(file);
            $previewForm.attr('src', url);
            $profileAvatar.attr('src', url);
            $('#removeCurrentPhoto').val('0');
            $removeBtn.removeClass('d-none').show();
        }

        // -------------------
        // Drag & Drop (robust file assignment)
        // -------------------
        const highlight = () => $dz.addClass('border-primary');
        const unhighlight = () => $dz.removeClass('border-primary');

        $dz.on('click', () => $file.trigger('click'));
        $dz.on('dragenter dragover', (e) => {
            e.preventDefault();
            highlight();
        });
        $dz.on('dragleave dragend drop', (e) => {
            e.preventDefault();
            unhighlight();
        });

        $dz.on('drop', function(e) {
            const dt = e.originalEvent.dataTransfer;
            if (dt?.files?.length) {
                const file = dt.files[0];
                // Use DataTransfer to assign to input (more compatible)
                try {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    $file[0].files = dataTransfer.files;
                } catch (err) {
                    // fallback for older browsers
                    $file.prop('files', dt.files);
                }
                handleFile(file);
            }
        });

        $file.on('change', function() {
            if (this.files?.[0]) handleFile(this.files[0]);
            clearFieldError($file);
        });

        // -------------------
        // Remove Avatar (keeps your existing ajax, with minor UX improvements)
        // -------------------
        $removeBtn.on('click', function() {
            Swal.fire({
                title: 'Bạn chắc chứ?',
                text: 'Hành động này sẽ xóa ảnh đại diện của bạn!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, xóa!',
                cancelButtonText: 'Hủy'
            }).then(result => {
                if (!result.isConfirmed) return;

                $removeBtn.prop('disabled', true);
                $.post('{{ route('admin.profile.remove-photo') }}', {
                    _token: '{{ csrf_token() }}'
                }).done(res => {
                    if (res.status === 'success') {
                        const src = res.avatar_url || defaultAvatar;
                        $previewForm.attr('src', src);
                        $profileAvatar.attr('src', src);
                        $('#previewAvatar').attr('src', src);
                        $('#removeCurrentPhoto').val('1');
                        $removeBtn.hide();
                        showAlert('success', 'Đã xóa!', res.message);
                    } else {
                        showAlert('error', 'Lỗi!', res.message || 'Xóa ảnh thất bại.');
                    }
                }).fail(xhr => {
                    showAlert('error', 'Lỗi!', xhr.responseJSON?.message || 'Không thể xóa ảnh.');
                }).always(() => {
                    $removeBtn.prop('disabled', false);
                });
            });
        });

        // -------------------
        // Live Preview Inputs + on-blur validation
        // -------------------
        $nameInput.on('input', () => {
            const v = $nameInput.val();
            $('#profileName').text(v);
            clearFieldError($nameInput);
        });

        $nameInput.on('blur', () => {
            const v = isValidName($nameInput.val());
            if (!v.ok) showFieldError($nameInput, v.msg);
            else clearFieldError($nameInput);
        });

        $phoneInput.on('input', function() {
            let val = this.value.replace(/\D/g, '').slice(0, 10);
            if (val.length === 1 && val !== '0') val = '0' + val;
            this.value = val;
            $('#profilePhone').text(val || '-');
            clearFieldError($phoneInput);
        });

        $phoneInput.on('blur', function() {
            const v = isValidPhone(this.value);
            if (!v.ok) showFieldError($phoneInput, v.msg);
            else clearFieldError($phoneInput);
        });

        $socialInput.on('input', function() {
            const val = $(this).val().trim();
            const $socialPreview = $('#socialPreview');
            if (val) $socialPreview.text(val).attr('href', val);
            else $socialPreview.text('No social link').removeAttr('href');
            clearFieldError($socialInput);
        });

        $socialInput.on('blur', function() {
            const v = normalizeAndValidateUrl($(this).val());
            if (!v.ok) {
                showFieldError($socialInput, v.msg);
            } else {
                // set normalized value back to input (helps server side)
                $(this).val(v.normalized);
                clearFieldError($socialInput);
            }
        });

        // -------------------
        // Form Submit (AJAX) with client-side validation
        // -------------------
        $form.on('submit', function(e) {
            e.preventDefault();
            clearValidation();
            setButtonLoading(true);

            // client-side validation
            const errors = [];
            const nameVal = $nameInput.val();
            const phoneVal = $phoneInput.val();
            const socialVal = $socialInput.val();
            const fileVal = $file[0]?.files?.[0] ?? null;

            const vName = isValidName(nameVal);
            if (!vName.ok) {
                showFieldError($nameInput, vName.msg);
                errors.push(vName.msg);
            }

            const vPhone = isValidPhone(phoneVal);
            if (!vPhone.ok) {
                showFieldError($phoneInput, vPhone.msg);
                errors.push(vPhone.msg);
            }

            const vSocial = normalizeAndValidateUrl(socialVal);
            if (!vSocial.ok) {
                showFieldError($socialInput, vSocial.msg);
                errors.push(vSocial.msg);
            }

            const vFile = validateImageFile(fileVal);
            if (!vFile.ok) {
                showFieldError($file, vFile.msg);
                errors.push(vFile.msg);
            }

            if (errors.length) {
                showAlert('error', 'Lỗi xác thực', errors.join('<br>'));
                setButtonLoading(false);
                return;
            }

            // Make sure social input contains normalized url (so server receives clean value)
            if (vSocial.normalized) $socialInput.val(vSocial.normalized);

            // prepare FormData
            const formData = new FormData(this);

            // If you want to ensure no accidental large files: re-check size in JS before sending
            if (fileVal && fileVal.size > 2 * 1024 * 1024) {
                showAlert('error', 'Ảnh quá lớn', 'Kích thước ảnh phải <= 2MB.');
                setButtonLoading(false);
                return;
            }

            // AJAX
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(res => {
                if (res.status === 'success') {
                    applyWidgetData(res.data);
                    showAlert('success', 'Thành công!', res.message);
                } else {
                    showAlert('error', 'Lỗi!', res.message || 'Cập nhật thất bại.');
                }
            }).fail(xhr => {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errs = xhr.responseJSON.errors;
                    let list = [];
                    for (const field in errs) {
                        // support array fields like 'image' or 'phone'
                        const $input = $form.find(`[name="${field}"]`);
                        if ($input.length) {
                            $input.addClass('is-invalid')
                                .after(`<div class="invalid-feedback d-block">${errs[field][0]}</div>`);
                        } else {
                            // fallback: attach to form top
                            $form.prepend(`<div class="alert alert-danger">${errs[field][0]}</div>`);
                        }
                        list.push(errs[field][0]);
                    }
                    showAlert('error', 'Lỗi xác thực từ server', list.join('<br>'));
                } else {
                    showAlert('error', 'Lỗi!', xhr.responseJSON?.message || 'Cập nhật thất bại.');
                }
            }).always(() => {
                setButtonLoading(false);
            });
        });

        // -------------------
        // Flash Messages (server -> client)
        // -------------------
        @if (session('success'))
            showAlert('success', 'Thành công!', @json(session('success')), 2000);
        @endif

        @if (session('error'))
            showAlert('error', 'Lỗi!', @json(session('error')));
        @endif
    });
</script>
@endpush
