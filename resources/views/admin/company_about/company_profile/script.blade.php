@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            // Initialize DataTable
            let table = $('#company-profile-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.company_about.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'section_key',
                        name: 'section_key'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Click edit button
            $('#company-profile-table').on('click', '.btn-edit', function() {
                let sectionKey = $(this).data('section');
                $('#modalSectionKey').val(sectionKey); // Set hidden input
                $.get(`/admin/company_about/${sectionKey}/edit`, function(html) {
                    $('#form-fields').html(html); // Load fields
                    $('#editProfileModal').modal('show');
                });
            });

            // Submit modal form
            $('#editProfileForm').on('submit', function(e) {
                e.preventDefault();
                let sectionKey = $('#modalSectionKey').val();

                $.ajax({
                    url: `/admin/company_about/${sectionKey}`,
                    method: 'PUT',
                    data: $(this).serialize(),
                    success: function(res) {
                        toastr.success(res.text, res.title);
                        table.ajax.reload(null, false);
                        $('#editProfileModal').modal('hide');
                    },
                    error: function(xhr) {
                        let err = xhr.responseJSON;
                        if (xhr.status === 422 && err.errors) {
                            let html = '<ul>';
                            $.each(err.errors, function(key, messages) {
                                html += `<li>${messages[0]}</li>`;
                            });
                            html += '</ul>';
                            $('#form-fields')
                            .prepend(
                                `<div class="alert alert-danger">${html}</div>`);
                        } else {
                            Swal.fire('Error', err?.text || 'Something went wrong!', 'error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
