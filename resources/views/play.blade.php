<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $game->name }} - Play Now - Infinite Playgrounds</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Minimal Bootstrap for utilities only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            min-height: 100vh !important;
            overflow-x: hidden !important;
        }

        /* Ensure consistent background - highest priority */
        html {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            min-height: 100vh !important;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        /* Game Header */
        .game-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .game-title {
            margin: 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .game-meta {
            display: flex;
            gap: 1rem;
            margin-top: 0.25rem;
        }

        .game-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .rating i {
            color: #fbbf24;
        }

        .header-right {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .control-btn, .like-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            text-decoration: none;
        }

        .control-btn:hover, .like-button:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }

        .like-button {
            gap: 0.5rem;
            padding: 0.75rem 1rem;
        }

        .like-button.liked {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
        }

        .like-button.liked:hover {
            background: rgba(239, 68, 68, 0.3);
        }

        .like-count {
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Game Main Area */
        .game-main {
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
        }

        .game-viewport {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .game-container {
            position: relative;
            perspective: 1000px;
        }

        .game-frame {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .game-frame::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        .game-content {
            width: 100%;
            position: relative;
            z-index: 2;
        }

        /* Game Overlay */
        .game-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        .game-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .overlay-content {
            text-align: center;
            color: #374151;
        }

        .game-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            animation: pulse 2s infinite;
        }

        .overlay-content h2 {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
        }

        .overlay-content p {
            margin: 0 0 2rem;
            color: #6b7280;
            font-weight: 500;
        }

        .loading-bar {
            width: 200px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .loading-progress {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
            width: 0%;
            animation: loading 2s ease-in-out forwards;
        }

        /* Floating Controls */
        .floating-controls {
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            z-index: 1000;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #374151;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .floating-btn:hover {
            background: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        /* Fullscreen Mode */
        .fullscreen-mode {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 2000;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fullscreen-mode .game-frame {
            width: 100%;
            height: 100%;
            border-radius: 0;
            background: #000;
            box-shadow: none;
        }

        .fullscreen-mode .game-content {
            height: 100%;
        }

        /* Animations */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes loading {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .game-frame {
            animation: slideIn 0.6s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .game-header {
                padding: 1rem;
            }
            
            .header-content {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .game-main {
                padding: 1rem;
                min-height: calc(100vh - 140px);
            }
            
            .game-frame {
                padding: 1.5rem;
                border-radius: 20px;
            }
            
            .game-title {
                font-size: 1.5rem;
            }
            
            .floating-controls {
                right: 1rem;
                bottom: 1rem;
            }
            
            .floating-btn {
                width: 48px;
                height: 48px;
            }
        }

        @media (max-width: 480px) {
            .game-frame {
                padding: 1rem;
                border-radius: 16px;
                margin: 0 0.5rem;
            }
            
            .header-left {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
            
            .game-meta {
                margin-top: 0.5rem;
            }
        }

        /* Game Content Styling */
        .game-content canvas,
        .game-content iframe {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .game-content > div {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>

    @if(!empty($game->css_code))
    <style>
        /* Game Custom Styles */
        {!! preg_replace('/body\s*{[^}]*}|html\s*{[^}]*}/', '', $game->css_code) !!}
        
        /* Force consistent page background - override any game styles */
        body, html {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Ensure our page styles have higher priority */
        .professional-play-page {
            background: transparent !important;
        }
    </style>
    @endif
</head>
<body>
    <div class="professional-play-page">
        <!-- Modern Header -->
        <header class="game-header">
            <div class="header-content">
                <div class="header-left">
                    <a href="{{ route('game.details', $game->id) }}" class="back-button">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back</span>
                    </a>
                    <div class="game-info">
                        <h1 class="game-title">{{ $game->name }}</h1>
                        
                    </div>
                </div>
                <div class="header-right">
                    <button class="control-btn" id="toggleFullscreen" title="Toggle Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                    @auth
                        <button class="like-button {{ $game->likes()->where('user_id', auth()->id())->exists() ? 'liked' : '' }}" 
                                data-game-id="{{ $game->id }}" title="Like this game">
                            <i class="fas fa-heart"></i>
                            <span class="like-count">{{ $game->likes()->count() }}</span>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="like-button" title="Login to like">
                            <i class="fas fa-heart"></i>
                            <span class="like-count">{{ $game->likes()->count() }}</span>
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Game Container -->
        <main class="game-main">
            <div class="game-viewport">
                <div class="game-container">
                    <div class="game-frame">
                        <div class="game-content" id="gameContent">
                            {!! $game->html_code !!}
                        </div>
                        <div class="game-overlay" id="gameOverlay">
                            <div class="overlay-content">
                                <div class="game-logo">
                                    <i class="fas fa-gamepad fa-2x"></i>
                                </div>
                                <h2>{{ $game->name }}</h2>
                                <p>Loading your game...</p>
                                <div class="loading-bar">
                                    <div class="loading-progress"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Floating Controls -->
        <div class="floating-controls">
            <button class="floating-btn" id="resetGame" title="Reset Game">
                <i class="fas fa-redo"></i>
            </button>
            <button class="floating-btn" id="shareGame" title="Share Game">
                <i class="fas fa-share-alt"></i>
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @if(!empty($game->js_code))
    <script>
        {!! $game->js_code !!}
    </script>
    @endif

    <script>
        $(document).ready(function() {
            // Hide loading overlay after game loads
            setTimeout(() => {
                $('#gameOverlay').addClass('hidden');
            }, 2000);
            
            // Fullscreen functionality
            $('#toggleFullscreen').click(function() {
                $('body').toggleClass('fullscreen-mode');
                
                if ($('body').hasClass('fullscreen-mode')) {
                    $(this).find('i').removeClass('fa-expand').addClass('fa-compress');
                } else {
                    $(this).find('i').removeClass('fa-compress').addClass('fa-expand');
                }
            });
            
            // Reset game
            $('#resetGame').click(function() {
                $('#gameOverlay').removeClass('hidden');
                setTimeout(() => {
                    location.reload();
                }, 500);
            });
            
            // Share game
            $('#shareGame').click(function() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $game->name }}',
                        text: 'Check out this awesome game!',
                        url: window.location.href
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Game link copied to clipboard!');
                    });
                }
            });
            
            // Like functionality
            $('.like-button').click(function(e) {
                e.preventDefault();
                
                @guest
                    window.location.href = "{{ route('login') }}";
                    return;
                @endguest

                const btn = $(this);
                const gameId = btn.data('game-id');
                const countElement = btn.find('.like-count');
                
                $.ajax({
                    url: `/game/${gameId}/like`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.action === 'liked') {
                            btn.addClass('liked');
                            countElement.text(parseInt(countElement.text()) + 1);
                        } else {
                            btn.removeClass('liked');
                            countElement.text(parseInt(countElement.text()) - 1);
                        }
                        
                        btn.css('transform', 'scale(1.1)');
                        setTimeout(() => {
                            btn.css('transform', '');
                        }, 200);
                    },
                    error: function(xhr) {
                        console.error('Like action failed');
                    }
                });
            });
            
            // Escape key for fullscreen
            $(document).keyup(function(e) {
                if (e.key === "Escape" && $('body').hasClass('fullscreen-mode')) {
                    $('body').removeClass('fullscreen-mode');
                    $('#toggleFullscreen').find('i').removeClass('fa-compress').addClass('fa-expand');
                }
            });
        });
    </script>
</body>
</html>