@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Manage Team Members')

@section('admin-content')
    <div class="container-fluid">
        <h2 class="section-title">Company Team Members</h2>
        <p class="section-lead">Manage all company team members here. You can edit each member using the action buttons.</p>

        <div class="card shadow-sm mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Team Members</h4>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="team-member-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Job Title</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Profile Image</th>
                                <th>Featured</th>
                                <th>Display Order</th>
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
            $('#team-member-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.company_about.company_team_member.index') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'job_title',
                        name: 'job_title'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'location',
                        name: 'location'
                    },
                    {
                        data: 'profile_image_url',
                        name: 'profile_image_url',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'is_featured',
                        name: 'is_featured',
                        orderable: true,
                        searchable: true,
                        render: function(data) {
                            return data ?
                                '<span class="badge bg-success">Yes</span>' :
                                '<span class="badge bg-secondary">No</span>';
                        }
                    },
                    {
                        data: 'display_order',
                        name: 'display_order'
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
                    [0, 'desc']
                ],
                dom: "<'d-flex justify-content-between align-items-center mb-3'f'l>" +
                    "rt" +
                    "<'d-flex justify-content-between align-items-center mt-3'p i>",
                responsive: true,
            });
        });
    </script>
@endpush
