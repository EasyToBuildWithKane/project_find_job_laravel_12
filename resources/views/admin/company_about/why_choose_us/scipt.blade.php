@push('scripts')
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', () => {
    try {
        // ===== Helper =====
        const showSwal = (type, title, text, timer = 2000) => {
            if (window.Swal) {
                Swal.fire({ icon: type, title, text, timer, showConfirmButton: false });
            } else {
                console.log(`[swal ${type}] ${title}: ${text}`);
            }
        };

        const form = document.getElementById('whyChooseUsForm');
        if (!form) {
            console.warn('whyChooseUsForm not found');
            return;
        }

        // ===== Elements =====
        const resetBtn = document.getElementById('resetBtn');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const btnText = submitBtn?.querySelector('.btn-text');

        // ===== Initial Values (safe JSON from Blade) =====
        const initialFormValues = @json([
            'section_title' => old('section_title', $item->section_title ?? ''),
            'section_subtitle' => old('section_subtitle', $item->section_subtitle ?? ''),
            'item_title' => old('item_title', $item->item_title ?? ''),
            'item_description' => old('item_description', $item->item_description ?? '')
        ]);

        // ===== Reset Form =====
        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                Object.keys(initialFormValues).forEach(name => {
                    const el = form.querySelector(`[name="${name}"]`);
                    if (el) el.value = initialFormValues[name] ?? '';
                });

                submitSpinner?.classList.add('d-none');
                if (btnText) btnText.textContent = 'Update';
                form.querySelectorAll('button').forEach(btn => btn.disabled = false);

                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            });
        }

        // ===== Submit =====
        form.addEventListener('submit', (e) => {
            // Nếu bạn muốn submit bằng AJAX: e.preventDefault();
            // e.preventDefault();

            submitSpinner?.classList.remove('d-none');
            if (btnText) btnText.textContent = 'Updating...';
            form.querySelectorAll('button').forEach(btn => btn.disabled = true);
        });

        // ===== Flash =====
        @if (session('success'))
            showSwal('success', 'Thành công', '{{ session('success') }}');
        @endif

    } catch (err) {
        console.error('Script error in whyChooseUsForm:', err);
    }
});
</script>
@endpush
