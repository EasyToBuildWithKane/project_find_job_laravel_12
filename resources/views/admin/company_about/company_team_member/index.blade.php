@extends('admin.layouts.master')
@section('module', 'Our Company')
@section('action', 'Team Members')

@section('admin-content')
    <h2 class="section-title">Team Members</h2>
    <p class="section-lead">Quản lý danh sách thành viên công ty</p>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="company-team-member-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Job Title</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>Image</th>
                            <th>Rating</th>
                            <th>Reviews</th>
                            <th>Featured</th>
                            <th>Order</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@include('admin.company_about.company_team_member._modal')
@include('admin.company_about.company_team_member.script')
