@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Games Management')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/tagify/tagify.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/css/admin/custom.css'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/sweetalert2/sweetalert2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/tagify/tagify.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/admin/game-list.js'])
@endsection

@section('content')

    <!-- Games List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <!-- Flex container for alignment -->
            <div class="d-flex justify-content-end p-2">
                <a class="btn btn-primary btn-sm add-new" data-bs-toggle="offcanvas" data-bs-target="#gameform"
                    href="{{ route('admin.games.store') }}" title="Form">
                    <span>
                        <i class="ti ti-plus ti-xs" style="margin-bottom: 2px;"></i>
                        <span class="d-none d-sm-inline-block btn_spacing">{{ __('Add Game') }}</span>
                    </span>
                </a>
            </div>
            <table class="datatables-game table" data-url="{{ route('admin.games.index') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Game Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Fields -->
        @include('admin.games.add-edit')
    </div>

@endsection
