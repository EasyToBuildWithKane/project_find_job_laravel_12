@extends('admin.layouts.master')
@section('module', 'Our Company')
@section('action', 'Manage Sections')

{{-- Include modal --}}
@include('admin.company_about.company_profile.modal')


@section('admin-content')
    <h2 class="section-title">Company Profile Sections</h2>
    <p class="section-lead">
        Manage all company profile sections here. You can edit each section using the modal.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Sections</h4>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="company-profile-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Section Key</th>
                                    <th>Title</th>
                                    <th class="text-center" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Include AJAX script --}}
    @include('admin.company_about.company_profile.script')
@endsection
