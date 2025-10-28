@push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ===== Helpers =====
    const fetchJson = async (url, options = {}) => {
        try {
            const res = await fetch(url, options);
            const data = await res.json();
            return { ok: res.ok, data };
        } catch (err) {
            console.error(err);
            return { 
                ok: false, 
                data: { message: 'Có lỗi xảy ra, vui lòng thử lại.' } 
            };
        }
    };

    const toggleButtonState = (form, disabled) => {
        form.querySelectorAll('button').forEach(btn => btn.disabled = disabled);
    };

    const resetValidationState = (form) => {
        form.querySelectorAll('.is-invalid')
            .forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    };

    const showSwal = (icon, title, text) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: 2000,
            showConfirmButton: false
        });
    };

    // ===== Form Elements =====
    const form = document.getElementById('statesForm');
    if (form) {
        const resetBtn = document.getElementById('resetBtn');
        const submitBtn = document.getElementById('submitBtn');
        const submitSpinner = document.getElementById('submitSpinner');
        const btnText = submitBtn?.querySelector('.btn-text');

        // ===== Initial Values =====
        const initialFormValues = {};
        form.querySelectorAll('[name]').forEach(el => {
            initialFormValues[el.name] = (el.type === 'checkbox') ? el.checked : el.value;
        });

        // ===== Reset Form =====
        resetBtn?.addEventListener('click', () => {
            for (const [name, value] of Object.entries(initialFormValues)) {
                const el = form.querySelector(`[name="${name}"]`);
                if (!el) continue;

                if (el.type === 'checkbox') el.checked = !!value;
                else el.value = value;
            }

            resetValidationState(form);
            submitSpinner.classList.add('d-none');
            btnText.textContent = 'Create';
            toggleButtonState(form, false);
        });

        // ===== Submit =====
        form.addEventListener('submit', () => {
            submitSpinner.classList.remove('d-none');
            btnText.textContent = 'Processing...';
            toggleButtonState(form, true);
        });
    }

    // ===== Flash Message =====
    @if (session('success'))
        showSwal('success', 'Thành công', '{{ session('success') }}');
    @endif

    @if (session('error'))
        showSwal('error', 'Thất bại', '{{ session('error') }}');
    @endif
});
</script>
@endpush


