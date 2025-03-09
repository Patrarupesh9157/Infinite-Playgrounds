@extends('layouts.app')

@section('title', 'Games - Infinite Playgrounds')

@section('content')
    <!-- ... previous header content ... -->

    <div class="single-product section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="left-image">
                        @if(!empty($game->images))
                            @php
                                $images = json_decode($game->images);
                                $firstImage = $images[0];
                            @endphp
                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $game->name }}">
                        @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $game->name }}">
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <h4>{{ $game->name }}</h4>
                    
                    <!-- Like and Rating Section -->
                    <div class="game-stats mb-4">
                        <div class="d-flex align-items-center gap-4">
                            <div class="likes-section">
                                <button class="btn {{ $userHasLiked ? 'btn-danger' : 'btn-outline-danger' }} like-btn"
                                        data-game-id="{{ $game->id }}"
                                        @guest disabled @endguest
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="{{ auth()->check() ? '' : 'Login to like this game' }}">
                                    <i class="fa fa-heart"></i>
                                    <span class="likes-count">{{ $game->likes_count }}</span>
                                </button>
                            </div>
                            <div class="rating-section">
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= round($averageRating) ? ' text-warning' : '-o' }}"></i>
                                    @endfor
                                    <span>({{ $reviews->count() }} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p>{{ $game->description }}</p>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" type="button" onclick="playGame()">
                            <i class="fa fa-gamepad"></i> Play Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="more-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs-content">
                        <div class="row">
                            <div class="nav-wrapper">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <button class="nav-link active" id="game-tab" data-bs-toggle="tab" 
                                                data-bs-target="#game" type="button" role="tab">
                                            Game
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                                                data-bs-target="#reviews" type="button" role="tab">
                                            Reviews ({{ $reviews->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="code-tab" data-bs-toggle="tab" 
                                                data-bs-target="#code" type="button" role="tab">
                                            Code
                                        </button>
                                    </li>
                                </ul>
                            </div>              
                            <div class="tab-content" id="myTabContent">
                                <!-- Game Tab -->
                                <div class="tab-pane fade show active" id="game" role="tabpanel">
                                    <div class="game-container">
                                        {!! $game->html_code !!}
                                    </div>
                                </div>

                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <!-- Review Form -->
                                    @auth
                                        <div class="review-form mb-4">
                                            <h5>Write a Review</h5>
                                            <form action="{{ route('game.review', $game->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label class="form-label">Rating</label>
                                                    <div class="rating-input">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                                            <label for="star{{ $i }}"><i class="fa fa-star"></i></label>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Your Review</label>
                                                    <textarea class="form-control" name="review" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit Review</button>
                                            </form>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            Please <a href="{{ route('login') }}">login</a> to write a review.
                                        </div>
                                    @endauth

                                    <!-- Reviews List -->
                                    <div class="reviews-list">
                                        @forelse($reviews as $review)
                                            <div class="review-item mb-4">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6>{{ $review->user->name }}</h6>
                                                        <div class="stars">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <i class="fa fa-star{{ $i <= $review->rating ? ' text-warning' : '-o' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mt-2">{{ $review->comment }}</p>
                                            </div>
                                            @unless($loop->last)
                                                <hr>
                                            @endunless
                                        @empty
                                            <p class="text-muted">No reviews yet. Be the first to review!</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- Code Tab -->
                                <div class="tab-pane fade" id="code" role="tabpanel">
                                    <!-- ... previous code content ... -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }
        .rating-input input {
            display: none;
        }
        .rating-input label {
            cursor: pointer;
            font-size: 1.5em;
            color: #ddd;
            padding: 0 2px;
        }
        .rating-input label:hover,
        .rating-input label:hover ~ label,
        .rating-input input:checked ~ label {
            color: #ffd700;
        }
        .review-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        .like-btn {
            padding: 8px 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .like-btn:hover {
            transform: scale(1.05);
        }

        .like-btn:active {
            transform: scale(0.95);
        }

        .like-btn i {
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        .like-btn.liked i {
            animation: pulse 0.5s ease;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Tooltip styling */
        .tooltip-inner {
            background-color: #333;
            color: #fff;
            border-radius: 4px;
            padding: 5px 10px;
        }

        .tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #333;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
            $('.like-btn').click(function(e) {
                e.preventDefault();
                @guest
                    window.location.href = "{{ route('login') }}";
                    return;
                @endguest

                const btn = $(this);
                const gameId = btn.data('game-id');
                
                $.ajax({
                    url: `/game/${gameId}/like`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.action === 'liked') {
                            btn.removeClass('btn-outline-danger').addClass('btn-danger');
                            btn.addClass('liked');
                        } else {
                            btn.removeClass('btn-danger').addClass('btn-outline-danger');
                        }
                        btn.find('.likes-count').text(response.likes_count);

                        // Remove the animation class after the animation ends
                        setTimeout(() => {
                            btn.removeClass('liked');
                        }, 500);
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
@endpush