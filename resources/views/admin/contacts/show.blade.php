@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Contact Message Details')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/css/admin/custom.css'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Contact Message Details</h4>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left ti-xs"></i> Back to Contact Messages
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Contact Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ $contact->name }} {{ $contact->surname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $contact->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Subject:</strong></td>
                                    <td>{{ $contact->subject ?? 'No subject' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date Sent:</strong></td>
                                    <td>{{ $contact->created_at->format('F j, Y, g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Message Details</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $contact->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 