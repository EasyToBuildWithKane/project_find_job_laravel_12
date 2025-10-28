 @push('scripts')
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

   
    const showSwal = (icon, title, text) => {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            timer: 2000,
            showConfirmButton: false
        });
    };

    @if (session('success'))
        showSwal('success', 'Thành công', '{{ session('success') }}');
    @endif

    @if (session('error'))
        showSwal('error', 'Thất bại', '{{ session('error') }}');
    @endif



    const form = document.getElementById('citiesForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitSpinner = document.getElementById('submitSpinner');

    if (form && submitBtn) {
        form.addEventListener('submit', () => {
            if (submitSpinner) submitSpinner.classList.remove('d-none');
            const btnText = submitBtn.querySelector('.btn-text');
            if (btnText) btnText.textContent = 'Đang xử lý...';
            submitBtn.disabled = true;
        });
    }


    /** ================================
     *  3️⃣ DataTable (Danh sách)
     * ================================ */
    const tableEl = document.getElementById('cities-table');
    if (tableEl) {
        const table = $('#cities-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.cities.index") }}',
            columns: [
                { data: 'id', name: 'id', width: '5%' },
                { data: 'name', name: 'name' },
                { data: 'state_name', name: 'state.name' },
                { data: 'country_name', name: 'country.name' },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    width: '15%'
                }
            ],
            language: {
                processing: "Đang tải dữ liệu...",
                search: "Tìm kiếm:",
                lengthMenu: "Hiển thị _MENU_ dòng",
                info: "Hiển thị _START_ đến _END_ trong _TOTAL_ dòng",
                infoEmpty: "Không có dữ liệu",
                zeroRecords: "Không tìm thấy kết quả phù hợp",
                paginate: { previous: "‹", next: "›" }
            }
        });


        /** ================================
         *  4️⃣ Xoá Thành Phố
         * ================================ */
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();

            const url = $(this).data('url');
            if (!url) {
                return Swal.fire('Lỗi!', 'Không tìm thấy đường dẫn xoá.', 'error');
            }

            Swal.fire({
                title: 'Bạn có chắc muốn xóa?',
                text: 'Hành động này không thể hoàn tác!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            Swal.fire('Thành công!', res.message, 'success');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Thất bại!', res.message || 'Không thể xóa.', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Lỗi!', 'Không thể kết nối server.', 'error'));
                }
            });
        });
    }


    /** ================================
     *  5️⃣ Filter State theo Country
     * ================================ */
    const countrySelect = document.getElementById('countrySelect');
    const stateSelect = document.getElementById('stateSelect');

    if (countrySelect && stateSelect) {
        const filterStates = () => {
            const selectedCountry = countrySelect.value;
            const currentStateValue = stateSelect.value;

            stateSelect.querySelectorAll('option').forEach(opt => {
                if (!opt.value) return;
                if (opt.value === currentStateValue) {
                    opt.style.display = 'block';
                } else {
                    opt.style.display = (opt.dataset.country === selectedCountry) ? 'block' : 'none';
                }
            });

            const currentState = stateSelect.querySelector(`option[value="${stateSelect.value}"]`);
            if (currentState && currentState.style.display === 'none') {
                stateSelect.value = '';
            }
        };

        countrySelect.addEventListener('change', filterStates);
        filterStates();
    }

});
</script>
@endpush
