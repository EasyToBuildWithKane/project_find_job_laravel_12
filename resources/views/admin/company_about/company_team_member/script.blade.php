@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            // ===== Helper =====
            const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };

            const fetchJson = async (url, options = {}) => {
                try {
                    const res = await fetch(url, options);
                    const data = await res.json();
                    return {
                        ok: res.ok,
                        data
                    };
                } catch (err) {
                    console.error(err);
                    return {
                        ok: false,
                        data: {
                            message: 'Có lỗi xảy ra, vui lòng thử lại'
                        }
                    };
                }
            };

            // ===== Form Elements =====
            const form = document.getElementById('teamMemberForm');
            if (!form) return;

            const profileInput = document.getElementById('profile_image_url');
            const profilePreview = document.getElementById('profileImagePreview');
            const removeImageBtn = document.getElementById('removeImageBtn');
            const resetBtn = document.getElementById('resetBtn');
            const submitBtn = document.getElementById('submitBtn');
            const submitSpinner = document.getElementById('submitSpinner');
            const btnText = submitBtn.querySelector('.btn-text');

            // ===== Initial Values =====
            const initialFormValues = {
                full_name: '{{ $member->full_name ?? '' }}',
                job_title: '{{ $member->job_title ?? '' }}',
                department: '{{ $member->department ?? '' }}',
                location: '{{ $member->location ?? '' }}',
                rating: '{{ $member->rating ?? 5 }}',
                review_count: '{{ $member->review_count ?? 0 }}',
                display_order: '{{ $member->display_order ?? 0 }}',
                is_featured: '{{ $member->is_featured ?? 0 }}'
            };

            const initialValues = {
                profile_image_url: '{{ isset($member) && $member->profile_image_url ? asset($member->profile_image_url) : asset('uploads/no_image.jpg') }}'
            };

            const memberId = {{ isset($member) ? $member->id : 'null' }};

            // ===== Image Functions =====
            const resetImage = () => {
                profilePreview.src = initialValues.profile_image_url;
                profilePreview.style.display = 'block';
                removeImageBtn.style.display =
                    '{{ isset($member) && $member->profile_image_url ? 'inline-block' : 'none' }}';
                profileInput.value = '';
            };

            profileInput?.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) {
                    profilePreview.src = URL.createObjectURL(file);
                    profilePreview.style.display = 'block';
                    removeImageBtn.style.display = 'inline-block';
                    profilePreview.onload = () => URL.revokeObjectURL(profilePreview.src);
                } else resetImage();
            });

            removeImageBtn?.addEventListener('click', async () => {
                if (!memberId) return;

                const result = await Swal.fire({
                    title: 'Bạn có chắc muốn xoá ảnh này?',
                    text: "Sau khi xoá sẽ không thể phục hồi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Có, xoá ngay!',
                    cancelButtonText: 'Huỷ'
                });

                if (!result.isConfirmed) return;

                const {
                    ok,
                    data
                } = await fetchJson(
                `/admin/company_about/company_team_member/remove-image/${memberId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });

                if (ok) {
                    resetImage();
                    showSwal('success', 'Thành công', data.message, 2500);
                } else {
                    showSwal('error', 'Lỗi', data.message);
                }
            });

            // ===== Reset Form =====
            resetBtn?.addEventListener('click', () => {
                Object.keys(initialFormValues).forEach(name => {
                    const el = form.querySelector(`[name="${name}"]`);
                    if (el) {
                        if (el.type === 'checkbox') {
                            el.checked = !!initialFormValues[name];
                        } else {
                            el.value = initialFormValues[name];
                        }
                    }
                });
                resetImage();

                submitSpinner.classList.add('d-none');
                btnText.textContent = 'Update';
                [...form.querySelectorAll('button')].forEach(btn => btn.disabled = false);

                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            });

            // ===== Submit =====
            form.addEventListener('submit', () => {
                submitSpinner.classList.remove('d-none');
                btnText.textContent = 'Updating...';
                [...form.querySelectorAll('button')].forEach(btn => btn.disabled = true);
            });

            // ===== Flash =====
            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif

        });
    </script>
@endpush
