@extends('admin.layouts.master')
@section('module', 'Our Company')
@section('action', 'Manage Sections')

@section('admin-content')
    <h2 class="section-title">Company Profile Sections</h2>
    <p class="section-lead">Manage all company profile sections here. You can edit each section using the modal.</p>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Sections</h4>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="company-profile-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section Key</th>
                            <th>Title</th>
                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@include('admin.company_about.company_profile._modal') {{-- Modal riêng --}}

@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            const table = $('#company-profile-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.company_about.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
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
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Mở modal edit
            $(document).on('click', '.btn-edit', function() {
                const sectionKey = $(this).data('section');
                $('#modalSectionKey').val(sectionKey);
                $('#form-errors').addClass('d-none').empty();
                $('#form-fields').html(
                    '<div class="text-center text-muted py-5"><i class="fas fa-spinner fa-spin me-2"></i> Loading...</div>'
                );
                $('#editProfileModal').modal('show');

                $.get(`/admin/company_about/${sectionKey}/edit`, function(res) {
                    $('#form-fields').html(res.html);
                });

            });

            // Submit modal form
            // Submit modal form
            $('#editProfileForm').on('submit', function(e) {
                e.preventDefault();
                const sectionKey = $('#modalSectionKey').val();
                const formData = new FormData(this);

                $.ajax({
                    url: `/admin/company_about/${sectionKey}`,
                    method: 'POST', // @method('PUT') sẽ spoof
                    data: formData,
                    processData: false,
                    contentType: false,
                    success(res) {
                        Swal.fire({
                            icon: res.icon || 'success',
                            title: res.title || 'Thành công',
                            text: res.text || 'Cập nhật thành công!',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        table.ajax.reload(null, false);
                        $('#editProfileModal').modal('hide');
                    },
                    error(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON.errors) {
                            let errorsHtml = '<ul>';
                            $.each(xhr.responseJSON.errors, (field, msgs) => {
                                errorsHtml += `<li>${msgs[0]}</li>`;
                            });
                            errorsHtml += '</ul>';
                            $('#form-errors').removeClass('d-none').html(errorsHtml);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi',
                                text: xhr.responseJSON?.message ||
                                    'Có lỗi xảy ra, vui lòng thử lại!'
                            });
                        }
                    }
                });
            });

        });
    </script>
@endpush
