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
                        <button class="btn btn-primary btn-lg" type="button" onclick="openGamePopup()">
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
                                        <div class="text-center p-5">
                                            <i class="fa fa-gamepad fa-4x text-primary mb-3"></i>
                                            <h4>Ready to Play?</h4>
                                            <p class="text-muted mb-4">Click the "Play Now" button above to launch the game in a popup window.</p>
                                            <button class="btn btn-primary" onclick="openGamePopup()">
                                                <i class="fa fa-play"></i> Launch Game
                                            </button>
                                        </div>
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
                                    <div class="code-section">
                                        @if($game->html_code)
                                            <div class="code-block">
                                                <div class="code-header d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0"><i class="fab fa-html5 text-danger me-2"></i>Game Source Code</h6>
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyCode('game-source-code')">
                                                        <i class="fa fa-copy me-1"></i>Copy Code
                                                    </button>
                                                </div>
                                                <pre class="code-content"><code id="game-source-code">{{ $game->html_code }}</code></pre>
                                            </div>
                                        @else
                                            <div class="no-code text-center py-5">
                                                <i class="fa fa-code fa-4x text-muted mb-3"></i>
                                                <h5>No Source Code Available</h5>
                                                <p class="text-muted">The source code for this game is not available for viewing.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Game Popup Modal -->
    <div class="modal fade" id="gameModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-gamepad me-2"></i>
                        {{ $game->name }}
                    </h5>
                    <div class="game-controls">
                        <button type="button" class="btn btn-sm btn-outline-light me-2" onclick="restartGame()">
                            <i class="fa fa-redo"></i> Restart
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i> Close
                        </button>
                    </div>
                </div>
                <div class="modal-body p-0">
                    <div id="gameContainer" class="game-iframe-container">
                        <!-- Game content will be loaded here -->
                        <div class="game-loading">
                            <div class="loading-spinner">
                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                            </div>
                            <h4>Loading Game...</h4>
                            <p>Please wait while the game initializes</p>
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

        /* Game Popup Styles */
        .game-iframe-container {
            width: 100%;
            height: calc(100vh - 60px);
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .game-content-frame {
            width: 100%;
            height: 100%;
            background: white;
            border: none;
            padding: 20px;
            overflow: auto;
        }

        .game-loading {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #666;
        }

        .loading-spinner {
            margin-bottom: 20px;
            color: #007bff;
        }

        .modal-fullscreen .modal-content {
            border-radius: 0;
        }

        .modal-header {
            border-bottom: 2px solid #495057;
        }

        .game-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .game-controls .btn {
            border-radius: 20px;
            font-size: 12px;
            padding: 5px 15px;
        }

        /* Code Section Styles */
        .code-block {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .code-header {
            background: #343a40;
            color: white;
            padding: 15px 20px;
        }

        .code-content {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            overflow-x: auto;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 14px;
            line-height: 1.6;
            max-height: 500px;
            margin: 0;
        }

        .no-code {
            background: white;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        /* Game placeholder */
        .game-container {
            background: #f8f9fa;
            border-radius: 10px;
            min-height: 400px;
            border: 2px dashed #dee2e6;
        }

        /* ESC key hint */
        .esc-hint {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            z-index: 1060;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .esc-hint.show {
            opacity: 1;
        }

        /* Responsive modal on mobile */
        @media (max-width: 768px) {
            .game-controls {
                flex-direction: column;
                gap: 5px;
            }
            
            .modal-header {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let gameModal;
        let gameLoaded = false;

        $(document).ready(function() {
            // Initialize modal
            gameModal = new bootstrap.Modal(document.getElementById('gameModal'));
            
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

            // ESC key to close modal
            $(document).keydown(function(e) {
                if (e.key === 'Escape' && $('#gameModal').hasClass('show')) {
                    gameModal.hide();
                }
            });

            // Show ESC hint when modal opens
            $('#gameModal').on('shown.bs.modal', function() {
                showEscHint();
            });

            // Clean up when modal closes
            $('#gameModal').on('hidden.bs.modal', function() {
                gameLoaded = false;
                $('#gameContainer').html(`
                    <div class="game-loading">
                        <div class="loading-spinner">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                        </div>
                        <h4>Loading Game...</h4>
                        <p>Please wait while the game initializes</p>
                    </div>
                `);
                hideEscHint();
            });
        });

        function openGamePopup() {
            // Show the modal
            gameModal.show();
            
            // Load the game content after modal is shown
            setTimeout(() => {
                loadGameContent();
            }, 300);
        }

        function loadGameContent() {
            const gameContainer = $('#gameContainer');
            
            @if($game->html_code)
                // Create game content HTML
                const gameHTML = `
                    <div class="game-content-frame">
                        @if($game->css_code)
                            <style>
                                {!! str_replace(["\r", "\n"], '', addslashes($game->css_code)) !!}
                            </style>
                        @endif
                        
                        <div class="game-html-content">
                            {!! str_replace(["\r", "\n"], '', addslashes($game->html_code)) !!}
                        </div>
                        
                        @if($game->js_code)
                            <script>
                                (function() {
                                    {!! str_replace(["\r", "\n"], '', addslashes($game->js_code)) !!}
                                })();
                            </script>
                        @endif
                    </div>
                `;
                
                // Replace loading screen with game content
                gameContainer.html(gameHTML);
                gameLoaded = true;
                
                // Try to initialize the game
                setTimeout(() => {
                    initializeGame();
                }, 100);
            @else
                // No game content available
                gameContainer.html(`
                    <div class="game-loading">
                        <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                        <h4>Game Not Available</h4>
                        <p>This game hasn't been configured yet.</p>
                    </div>
                `);
            @endif
        }

        function initializeGame() {
            // Try to call common game initialization functions
            try {
                if (typeof window.startGame === 'function') {
                    window.startGame();
                } else if (typeof window.initGame === 'function') {
                    window.initGame();
                } else if (typeof window.init === 'function') {
                    window.init();
                } else if (typeof window.setup === 'function') {
                    window.setup();
                }
            } catch (error) {
                console.log('Game initialization:', error);
            }
        }

        function restartGame() {
            if (gameLoaded) {
                try {
                    if (typeof window.resetGame === 'function') {
                        window.resetGame();
                    } else if (typeof window.restartGame === 'function') {
                        window.restartGame();
                    } else if (typeof window.restart === 'function') {
                        window.restart();
                    } else {
                        // Fallback: reload the game content
                        loadGameContent();
                    }
                } catch (error) {
                    console.log('Game restart:', error);
                    // Fallback: reload the game content
                    loadGameContent();
                }
            }
        }

        function showEscHint() {
            if (!$('.esc-hint').length) {
                $('body').append(`
                    <div class="esc-hint">
                        Press <strong>ESC</strong> to close game
                    </div>
                `);
            }
            
            setTimeout(() => {
                $('.esc-hint').addClass('show');
            }, 1000);
            
            setTimeout(() => {
                hideEscHint();
            }, 4000);
        }

        function hideEscHint() {
            $('.esc-hint').removeClass('show');
            setTimeout(() => {
                $('.esc-hint').remove();
            }, 300);
        }

        function copyCode(elementId) {
            const element = document.getElementById(elementId);
            if (!element) return;
            
            const text = element.textContent;
            
            navigator.clipboard.writeText(text).then(function() {
                alert('Code copied to clipboard!');
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                try {
                    document.execCommand('copy');
                    alert('Code copied to clipboard!');
                } catch (err) {
                    alert('Failed to copy code. Please copy manually.');
                }
                
                document.body.removeChild(textArea);
            });
        }
    </script>
@endpush