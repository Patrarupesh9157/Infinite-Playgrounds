@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('page-script')
    @vite(['resources/assets/js/admin/dashboard.js'])
@endsection
@section('title', 'Home')

@section('content')
<h4>Dashboard Page</h4>
<div class="row mb-4">
    <!-- Games Section -->
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary">
                            <img class="v-img__img v-img__img--cover" src="{{ asset('images/product-12.png') }}" alt="" style="">
                        </span>
                    </div>
                    <h4 class="mb-0" id="games-count">0</h4> <!-- Updated id for games count -->
                </div>
                <p class="mb-1">Total Games</p> <!-- Updated label for games -->
            </div>
        </div>
    </div>
    
    <!-- Total Likes Section -->
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-heart ti-28px ti-md"></i> <!-- Icon for total likes -->
                        </span>
                    </div>
                    <h4 class="mb-0" id="likes-count">0</h4> <!-- ID for total likes -->
                </div>
                <p class="mb-1">Total Likes</p> <!-- Label for total likes -->
            </div>
        </div>
    </div>

    <!-- Total Reviews Section -->
    <div class="col-lg-3 col-sm-6">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-message-dots ti-28px ti-md"></i> <!-- Icon for total reviews -->
                        </span>
                    </div>
                    <h4 class="mb-0" id="reviews-count">0</h4> <!-- ID for total reviews -->
                </div>
                <p class="mb-1">Total Reviews</p> <!-- Label for total reviews -->
            </div>
        </div>
    </div>
</div>

<!-- <p>For more layout options refer <a href="{{ config('variables.documentation') ? config('variables.documentation').'/laravel-introduction.html' : '#' }}" target="_blank" rel="noopener noreferrer">documentation</a>.</p> -->
@endsection
