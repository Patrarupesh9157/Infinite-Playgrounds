@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Review Details')

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
                    <h4 class="card-title">Review Details</h4>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left ti-xs"></i> Back to Reviews
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Review Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Rating:</strong></td>
                                    <td>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="ti ti-star-filled text-warning"></i>
                                            @else
                                                <i class="ti ti-star text-muted"></i>
                                            @endif
                                        @endfor
                                        ({{ $review->rating }}/5)
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Game:</strong></td>
                                    <td>{{ $review->game->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>User:</strong></td>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ $review->created_at->format('F j, Y, g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $review->updated_at->format('F j, Y, g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>User Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $review->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Registered:</strong></td>
                                    <td>{{ $review->user->created_at->format('F j, Y') ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Review Comment</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-0">{{ $review->comment ?? 'No comment provided.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 