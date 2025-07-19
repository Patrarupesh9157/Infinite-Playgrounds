@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'User Details')

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
                    <h4 class="card-title">User Details</h4>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ti ti-arrow-left ti-xs"></i> Back to Users
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Basic Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email Verified:</strong></td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Verified</span>
                                        @else
                                            <span class="badge bg-warning">Not Verified</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Registered:</strong></td>
                                    <td>{{ $user->created_at->format('F j, Y, g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $user->updated_at->format('F j, Y, g:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Activity Summary</h5>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $user->reviews->count() }}</h3>
                                            <p class="mb-0">Reviews</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h3>{{ $user->likes->count() }}</h3>
                                            <p class="mb-0">Likes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Reviews -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Reviews ({{ $user->reviews->count() }})</h4>
                </div>
                <div class="card-body">
                    @if($user->reviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Game</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->reviews as $review)
                                        <tr>
                                            <td>{{ $review->game->name ?? 'N/A' }}</td>
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
                                            <td>{{ \Illuminate\Support\Str::limit($review->comment, 100) }}</td>
                                            <td>{{ $review->created_at->format('F j, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No reviews found for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- User Likes -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Liked Games ({{ $user->likes->count() }})</h4>
                </div>
                <div class="card-body">
                    @if($user->likes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Game</th>
                                        <th>Liked Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->likes as $like)
                                        <tr>
                                            <td>{{ $like->game->name ?? 'N/A' }}</td>
                                            <td>{{ $like->created_at->format('F j, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">No liked games found for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection 