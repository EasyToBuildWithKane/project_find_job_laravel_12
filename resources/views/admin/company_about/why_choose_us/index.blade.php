@extends('admin.layouts.master')

@section('module', 'Our Company')
@section('action', 'Manage Why Choose Us')

@section('admin-content')
<div class="container-fluid">
    <h2 class="section-title">Why Choose Us</h2>
    <p class="section-lead">
        Manage all "Why Choose Us" items here. You can edit each item using the action buttons.
    </p>

    <div class="card shadow-sm mt-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Why Choose Us Items</h4>
            <a href="{{ route('admin.company_about.why_choose_us.create') }}" class="btn btn-primary">+ Add New</a>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="why-choose-us-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Section Title</th>
                            <th>Section Subtitle</th>
                            <th>Item Title</th>
                            <th>Item Description</th>
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
$(function () {
    // ===== Flash message helper =====
    const showSwal = (type, title, text, timer = 2000) => {
        Swal.fire({ icon: type, title, text, timer, showConfirmButton: false });
    };

    @if (session('success'))
        showSwal('success', 'Thành công', '{{ session('success') }}');
    @endif

    // ===== DataTable =====
    $('#why-choose-us-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.company_about.why_choose_us.index') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'section_title', name: 'section_title' },
            { data: 'section_subtitle', name: 'section_subtitle' },
            { data: 'item_title', name: 'item_title' },
            { 
                data: 'item_description', 
                name: 'item_description',
                render: function(data) {
                    return data ? data.substring(0, 50) + '...' : '';
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],
        order: [[0, 'asc']],
        responsive: true,
        columnDefs: [
            { targets: ['action'], orderable: false, searchable: false }
        ],
        dom: "<'d-flex justify-content-between align-items-center mb-3'f'l>" +
             "rt" +
             "<'d-flex justify-content-between align-items-center mt-3'p i>"
    });
});
</script>
@endpush
