@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
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
            const form = document.getElementById('companyProfileForm');
            if (!form) return;

            const featuredInput = document.getElementById('featured_image_url');
            const featuredPreview = document.getElementById('featuredImagePreview');
            const removeImageBtn = document.getElementById('removeImageBtn');
            const resetBtn = document.getElementById('resetBtn');
            const submitBtn = document.getElementById('submitBtn');
            const submitSpinner = document.getElementById('submitSpinner');
            const btnText = submitBtn.querySelector('.btn-text');

            // ===== Initial Values =====
            const initialFormValues = {
                section_key: '{{ $profile->section_key }}',
                title: '{{ $profile->title }}',
                headline: '{{ $profile->headline }}',
                cta_label: '{{ $profile->cta_label }}',
                cta_link: '{{ $profile->cta_link }}',
                summary: '{{ $profile->summary }}',
                body: '{{ $profile->body }}'
            };

            const initialValues = {
                featured_image_url: '{{ isset($profile) && $profile->featured_image_url ? asset($profile->featured_image_url) : asset('uploads/no_image.jpg') }}'
            };

            const profileId = {{ isset($profile) ? $profile->id : 'null' }};

            // ===== Image Functions =====
            const resetImage = () => {
                featuredPreview.src = initialValues.featured_image_url;
                featuredPreview.style.display = 'block';
                removeImageBtn.style.display =
                    '{{ isset($profile) && $profile->featured_image_url ? 'inline-block' : 'none' }}';
                featuredInput.value = '';
            };

            featuredInput?.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) {
                    featuredPreview.src = URL.createObjectURL(file);
                    featuredPreview.style.display = 'block';
                    removeImageBtn.style.display = 'inline-block';
                    featuredPreview.onload = () => URL.revokeObjectURL(featuredPreview.src);
                } else resetImage();
            });

            removeImageBtn?.addEventListener('click', async () => {
                if (!profileId) return;

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
                } = await fetchJson(`/admin/company_about/profile/remove_image/${profileId}`, {
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
                // Reset tất cả input & textarea về giá trị ban đầu (PUT)
                Object.keys(initialFormValues).forEach(name => {
                    const el = form.querySelector(`[name="${name}"]`);
                    if (el) el.value = initialFormValues[name];
                });

                // Reset image về giá trị ban đầu
                resetImage();

                // Reset submit button
                submitSpinner.classList.add('d-none');
                btnText.textContent = 'Update';
                [...form.querySelectorAll('button')].forEach(btn => btn.disabled = false);

                // Remove validation errors
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
