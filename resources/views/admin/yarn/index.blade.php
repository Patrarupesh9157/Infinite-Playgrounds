<!-- resources/views/admin/yarns/index.blade.php -->
@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Yarns Management')

@section('vendor-style')
    @vite([
        'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
        'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
        'resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
        'resources/assets/vendor/libs/@form-validation/form-validation.scss',
        'resources/assets/vendor/libs/tagify/tagify.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/moment/moment.js',
        'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
        'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/vendor/libs/@form-validation/popular.js',
        'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
        'resources/assets/vendor/libs/@form-validation/auto-focus.js',
        'resources/assets/vendor/libs/tagify/tagify.js'
    ])
@endsection

@section('page-script')
    @vite(['resources/assets/js/admin/yarn-list.js']) <!-- Update the script to match yarn list -->
@endsection

@section('content')

    <!-- Yarns List Table -->
    <div class="card">
        <div class="card-datatable table-responsive">
            <!-- Flex container for alignment -->
            <div class="d-flex justify-content-end p-2">
                <a class="btn btn-primary btn-sm add-new" data-bs-toggle="offcanvas" data-bs-target="#yarnform"
                    href="{{ route('admin.category.yarn.store') }}" title="Form">
                    <span>
                        <i class="ti ti-plus ti-xs" style="margin-bottom: 2px;"></i>
                        <span class="d-none d-sm-inline-block btn_spacing">{{ __('Add Yarn') }}</span>
                    </span>
                </a>
            </div>
            <table class="datatables-yarn table" data-url="{{ route('admin.category.yarn.index') }}">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <!-- <th>Created At</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        <!-- Fields -->
        @include('admin.yarn.add-edit') <!-- Update partial view to match yarn add/edit form -->
    </div>

@endsection
