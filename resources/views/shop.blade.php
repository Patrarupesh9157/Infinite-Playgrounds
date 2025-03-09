@extends('layouts.app')

@section('title', 'Games - Infinite Playgrounds')


@push('styles')
    <style>
        .item .down-content {
            padding: 20px;
            background: #f7f7f7;
            border-radius: 0 0 15px 15px;
        }
        .item .thumb {
            position: relative;
            overflow: hidden;
            border-radius: 15px 15px 0 0;
        }
        .item .thumb img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <div class="page-heading header-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3>Our Games</h3>
                    <span class="breadcrumb">
                        <a href="{{ route('home') }}">Home</a> > Our Games
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="section trending">
        <div class="container">
            <div class="row trending-box">
                @forelse($games as $game)
                    <div class="col-lg-3 col-md-6 align-self-center mb-30">
                        <div class="item">
                            <div class="thumb">
                                <a href="{{ route('game.details', $game->id) }}">
                                    @if(!empty($game->images))
                                        @php
                                        $images = json_decode($game->images, true)
                                        
                                        @endphp
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $game->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $game->name }}">
                                    @endif
                                </a>
                            </div>
                            <div class="down-content">
                                <h4>{{ $game->name }}</h4>
                                <p class="text-truncate">{{ $game->description }}</p>
                                <div class="mt-2">
                                    <small class="text-muted">Created: {{ $game->created_at }}</small>
                                </div>
                                <div class="mt-2 d-flex justify-content-center align-items-center">
                                    <a href="{{ route('game.details', $game->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <h4>No games available</h4>
                    </div>
                @endforelse
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{ $games->links('sections.shop.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

