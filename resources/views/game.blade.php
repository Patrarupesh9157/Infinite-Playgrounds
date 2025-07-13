@extends('layouts.app')

@section('title', 'Games - Infinite Playgrounds')

@section('content')
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
                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $game->name }}" class="img-fluid rounded shadow">
                        @else
                            <img src="{{ asset('assets/images/placeholder.jpg') }}" alt="{{ $game->name }}" class="img-fluid rounded shadow">
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
                        <a  href="{{ route('games.play', $game->id) }}" class="btn btn-primary btn-lg play-button">
                            <i class="fa fa-gamepad me-2"></i> Play Now
                        </a>
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
                                        <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab" 
                                                data-bs-target="#reviews" type="button" role="tab">
                                            <i class="fa fa-comments me-2"></i> Reviews ({{ $reviews->count() }})
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" id="code-tab" data-bs-toggle="tab" 
                                                data-bs-target="#code" type="button" role="tab">
                                            <i class="fa fa-code me-2"></i> Code
                                        </button>
                                    </li>
                                </ul>
                            </div>              
                            <div class="tab-content" id="myTabContent">

                                <!-- Reviews Tab -->
                                <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                                    <div class="reviews-container p-4 bg-white rounded shadow-sm">
                                        <!-- Review Stats Summary -->
                                        <div class="review-summary mb-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-4 text-center border-end">
                                                    <h2 class="display-4 mb-0">{{ number_format($averageRating, 1) }}</h2>
                                                    <div class="stars mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star{{ $i <= round($averageRating) ? ' text-warning' : '-o' }} fs-4"></i>
                                                        @endfor
                                                    </div>
                                                    <p class="text-muted">{{ $reviews->count() }} {{ \Illuminate\Support\Str::plural('review', $reviews->count()) }}</p>
                                                </div>
                                                <div class="col-md-8">
                                                    @php
                                                        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                        foreach($reviews as $review) {
                                                            $ratingCounts[$review->rating]++;
                                                        }
                                                    @endphp
                                                    
                                                    @for($i = 5; $i >= 1; $i--)
                                                        @php
                                                            $percentage = $reviews->count() > 0 ? ($ratingCounts[$i] / $reviews->count()) * 100 : 0;
                                                        @endphp
                                                        <div class="rating-bar d-flex align-items-center mb-2">
                                                            <span class="me-2">{{ $i }} <i class="fa fa-star text-warning"></i></span>
                                                            <div class="progress flex-grow-1" style="height: 8px;">
                                                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%"></div>
                                                            </div>
                                                            <span class="ms-2 text-muted small">{{ $ratingCounts[$i] }}</span>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr>
                                        
                                        <!-- Review Form -->
                                        @auth
                                            <div class="review-form mb-4 mt-4">
                                                <h5 class="mb-3"><i class="fa fa-pencil me-2"></i>Write a Review</h5>
                                                <form action="{{ route('game.review', $game->id) }}" method="POST" class="bg-light p-4 rounded">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Your Rating</label>
                                                        <div class="rating-input text-center">
                                                            @for($i = 5; $i >= 1; $i--)
                                                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                                                                <label for="star{{ $i }}"><i class="fa fa-star"></i></label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Your Review</label>
                                                        <textarea class="form-control" name="review" rows="3" placeholder="Share your thoughts about this game..." required></textarea>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fa fa-paper-plane me-1"></i> Submit Review
                                                        </button>
                                                    </div>
                                                </form>
                                                @if ($errors->any())
                                                    <div class="alert alert-danger mt-3">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle me-2"></i> Please <a href="{{ route('login') }}" class="alert-link">login</a> to write a review.
                                            </div>
                                        @endauth

                                        <!-- Reviews List -->
                                        <div class="reviews-list mt-4">
                                            <h5 class="mb-3"><i class="fa fa-comments me-2"></i>User Reviews</h5>
                                            
                                            @forelse($reviews as $review)
                                                <div class="review-item mb-4">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div class="d-flex">
                                                            <div class="avatar me-3">
                                                                <div class="avatar-circle">
                                                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-1">{{ $review->user->name }}</h6>
                                                                <div class="stars mb-1">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="fa fa-star{{ $i <= $review->rating ? ' text-warning' : '-o' }}"></i>
                                                                    @endfor
                                                                    <span class="text-muted ms-2 small">{{ $review->created_at->diffForHumans() }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="review-content mt-2">
                                                        <p class="mb-0">{{ $review->comment }}</p>
                                                    </div>
                                                </div>
                                                @unless($loop->last)
                                                    <hr>
                                                @endunless
                                            @empty
                                                <div class="text-center py-5">
                                                    <i class="fa fa-comments-o fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">No reviews yet. Be the first to review this game!</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <!-- Code Tab -->
                                <div class="tab-pane fade" id="code" role="tabpanel">
                                    <div class="code-container">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5><i class="fa fa-code me-2"></i> Game Code</h5>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary code-tab-btn active" data-target="html">HTML</button>
                                                <button class="btn btn-sm btn-outline-primary code-tab-btn" data-target="css">CSS</button>
                                                <button class="btn btn-sm btn-outline-primary code-tab-btn" data-target="js">JavaScript</button>
                                            </div>
                                        </div>
                                        
                                        <div class="code-content">
                                            <div class="code-tab-content active" id="html-code">
                                                <div class="code-header d-flex justify-content-between align-items-center bg-light p-2 rounded-top">
                                                    <span>HTML</span>
                                                    <button class="btn btn-sm btn-primary copy-code" data-code-type="html">
                                                        <i class="fa fa-copy me-1"></i> Copy
                                                    </button>
                                                </div>
                                                <pre class="bg-dark text-light p-3 rounded-bottom mb-0"><code class="html">{{ $game->html_code ?? '<div class="game-container">Game HTML code will appear here</div>' }}</code></pre>
                                            </div>
                                            
                                            <div class="code-tab-content" id="css-code" style="display: none;">
                                                <div class="code-header d-flex justify-content-between align-items-center bg-light p-2 rounded-top">
                                                    <span>CSS</span>
                                                    <button class="btn btn-sm btn-primary copy-code" data-code-type="css">
                                                        <i class="fa fa-copy me-1"></i> Copy
                                                    </button>
                                                </div>
                                                <pre class="bg-dark text-light p-3 rounded-bottom mb-0"><code class="css">{{ $game->css_code ?? '/* Game CSS code will appear here */' }}</code></pre>
                                            </div>
                                            
                                            <div class="code-tab-content" id="js-code" style="display: none;">
                                                <div class="code-header d-flex justify-content-between align-items-center bg-light p-2 rounded-top">
                                                    <span>JavaScript</span>
                                                    <button class="btn btn-sm btn-primary copy-code" data-code-type="js">
                                                        <i class="fa fa-copy me-1"></i> Copy
                                                    </button>
                                                </div>
                                                <pre class="bg-dark text-light p-3 rounded-bottom mb-0"><code class="javascript">{{ $game->js_code ?? '// Game JavaScript code will appear here' }}</code></pre>
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
    </div>
@endsection

@push('styles')
    <style>
        /* Rating system styling */
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
            font-size: 2em;
            color: #ddd;
            padding: 0 5px;
            transition: all 0.2s ease;
        }
        .rating-input label:hover,
        .rating-input label:hover ~ label,
        .rating-input input:checked ~ label {
            color: #ffd700;
            transform: scale(1.1);
        }
        
        /* Review item styling */
        .review-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .review-item:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        /* Avatar circle */
        .avatar-circle {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            font-size: 18px;
        }
        
        /* Review form styling */
        .review-form form {
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .review-form form:focus-within {
            box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
        }
        
        /* Like button styling */
        .like-btn {
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .like-btn i {
            margin-right: 5px;
        }
        
        /* Code display styling */
        pre {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 0;
            border-radius: 0 0 5px 5px;
        }
        
        .code-tab-btn {
            font-size: 0.85rem;
            padding: 4px 10px;
        }
        
        .code-tab-btn.active {
            background-color: #007bff;
            color: white;
        }
        
        /* Reviews container */
        .reviews-container {
            border: 1px solid #eee;
        }
        
        /* Rating bars */
        .rating-bar .progress {
            border-radius: 4px;
            background-color: #eee;
        }
        
        .rating-bar .progress-bar {
            border-radius: 4px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // Like button functionality
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
                        } else {
                            btn.removeClass('btn-danger').addClass('btn-outline-danger');
                        }
                        btn.find('.likes-count').text(response.likes_count);
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
            
            // Code tab switching
            $('.code-tab-btn').click(function() {
                const target = $(this).data('target');
                
                // Update active button
                $('.code-tab-btn').removeClass('active');
                $(this).addClass('active');
                
                // Show target content
                $('.code-tab-content').hide();
                $(`#${target}-code`).show();
            });
            
            // Copy code functionality
            $('.copy-code').click(function() {
                const codeType = $(this).data('code-type');
                const codeContent = $(`#${codeType}-code pre code`).text();
                
                // Create temporary textarea
                const textarea = document.createElement('textarea');
                textarea.value = codeContent;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                
                // Update button text temporarily
                const btn = $(this);
                const originalText = btn.html();
                btn.html('<i class="fa fa-check me-1"></i> Copied!');
                setTimeout(() => {
                    btn.html(originalText);
                }, 2000);
            });
        });
    </script>
@endpush