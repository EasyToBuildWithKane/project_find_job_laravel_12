@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Manage Sections')

@section('admin-content')
    <div class="container-fluid">
        <h2 class="section-title">Company Profile Sections</h2>
        <p class="section-lead">Manage all company profile sections here. You can edit each section using the action buttons.
        </p>

        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Sections</h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="company-profile-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Section Key</th>
                                <th>Title</th>
                                <th>Headline</th>
                                <th>Image</th>
                                <th>CTA Label</th>
                                <th>CTA Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>
    <script>
        $(function() {

               const showSwal = (type, title, text, timer = 2000) => {
                Swal.fire({
                    icon: type,
                    title,
                    text,
                    timer,
                    showConfirmButton: false
                });
            };
               // ===== Flash =====
            @if (session('success'))
                showSwal('success', 'Thành công', '{{ session('success') }}');
            @endif



            $('#company-profile-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.company_about.company_profile.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
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
                        data: 'headline',
                        name: 'headline'
                    },
                    {
                        data: 'featured_image_url',
                        name: 'featured_image_url',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cta_label',
                        name: 'cta_label'
                    },
                    {
                        data: 'cta_link',
                        name: 'cta_link'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                order: [

                    [0, 'asc']

                ],
                dom: "<'d-flex justify-content-between align-items-center mb-3'f'l>" +
                    "rt" + // table
                    "<'d-flex justify-content-between align-items-center mt-3'p i>",
                responsive: true,
            });
        });
    </script>
@endpush
