@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', () => {
            try {
                // ===== Helper: Hiển thị thông báo (fallback nếu Swal chưa load) =====
                const showSwal = (type, title, text, timer = 2000) => {
                    if (window.Swal) {
                        Swal.fire({
                            icon: type,
                            title,
                            text,
                            timer,
                            showConfirmButton: false
                        });
                    } else {
                        console.log(`[swal ${type}] ${title}: ${text}`);
                    }
                };

                // ===== Element =====
                const form = document.getElementById('whyChooseUsForm');
                const resetBtn = document.getElementById('resetBtn');
                const submitBtn = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                const btnText = submitBtn?.querySelector('.btn-text');

                if (!form) {
                    console.warn('Không tìm thấy form #whyChooseUsForm');
                    return;
                }
                @php
                    $initialFormValues = [
                        'section_title' => old('section_title', $item->section_title ),
                        'section_subtitle' => old('section_subtitle', $item->section_subtitle ),
                        'item_title' => old('item_title', $item->item_title ),
                        'item_description' => old('item_description', $item->item_description ),
                    ];
                @endphp


                const initialFormValues = {!! json_encode($initialFormValues, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!};



                // ======= Submit Loading State =======
                form.addEventListener('submit', (e) => {
                    // Nếu bạn muốn submit AJAX thì bỏ comment dòng dưới:
                    // e.preventDefault();

                    submitBtn.disabled = true;
                    spinner?.classList.remove('d-none');
                    if (btnText) btnText.textContent = 'Đang lưu...';
                });

                // ======= Reset Form Confirm =======
                if (resetBtn) {
                    resetBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Xác nhận đặt lại?',
                            text: 'Tất cả thay đổi chưa lưu sẽ bị mất!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Đặt lại',
                            cancelButtonText: 'Hủy',
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Khôi phục lại giá trị ban đầu
                                Object.keys(initialFormValues).forEach(name => {
                                    const el = form.querySelector(`[name="${name}"]`);
                                    if (el) el.value = initialFormValues[name] ;
                                });

                                // Xóa lỗi validation
                                form.querySelectorAll('.is-invalid').forEach(el => el.classList
                                    .remove('is-invalid'));
                                form.querySelectorAll('.invalid-feedback').forEach(el => el
                                    .remove());

                                // Reset trạng thái nút
                                spinner?.classList.add('d-none');
                                if (btnText) btnText.textContent = 'Cập nhật';
                                submitBtn.disabled = false;

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đã đặt lại!',
                                    text: 'Form đã được khôi phục giá trị ban đầu.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        });
                    });
                }

                // ======= Thông báo thành công (Flash session) =======
                @if (session('success'))
                    showSwal('success', 'Thành công', '{{ session('success') }}');
                @endif

                // ======= Hiển thị lỗi xác thực (Laravel Validation) =======
                @if ($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi xác thực!',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonText: 'Đóng',
                        confirmButtonColor: '#d33'
                    });
                @endif

            } catch (err) {
                console.error(' Lỗi script tại whyChooseUsForm:', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi không mong muốn!',
                    text: 'Có lỗi xảy ra trong quá trình khởi tạo form. Vui lòng tải lại trang.',
                    confirmButtonText: 'Tải lại',
                    confirmButtonColor: '#d33'
                }).then(() => window.location.reload());
            }
        });
    </script>
@endpush
