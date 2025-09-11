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
        <div class="card-body p-4
            ">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="company-profile-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Section Key</th>
                            <th>Title</th>
                            <th>Headline</th>
                            <th>Featured Image</th>
                            <th>CTA Label</th>
                            <th>CTA Link</th>

                            <th class="text-center" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@include('admin.company_about.company_profile._modal') {{-- Modal riêng --}}
@include('admin.company_about.company_profile.script') {{-- Script riêng --}}
