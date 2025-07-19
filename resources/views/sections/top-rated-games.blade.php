<div class="section trending">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h6>Top Rated Games</h6>
                    <h2>Highest Rated by Our Community</h2>
                </div>
            </div>
        </div>
        
        <div class="row trending-box">
            @forelse($topRatedGames as $game)
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
                            <!-- Rating badge -->
                            <div class="rating-badge">
                                <span class="rating-number">{{ number_format($game->reviews_avg_rating, 1) }}</span>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= round($game->reviews_avg_rating) ? ' text-warning' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <small class="review-count">({{ $game->reviews_count }} {{ \Illuminate\Support\Str::plural('review', $game->reviews_count) }})</small>
                            </div>
                        </div>
                        <div class="down-content">
                            <h4>{{ $game->name }}</h4>
                            <p class="text-truncate">{{ $game->description }}</p>
                            
                            <!-- Top review snippet if available -->
                            @php
                                $topReview = $game->reviews->first();
                            @endphp
                            @if($topReview)
                                <div class="review-snippet mt-2">
                                    <div class="stars mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star{{ $i <= $topReview->rating ? ' text-warning' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="text-muted small mb-2">{{ Str::limit($topReview->comment, 80) }}</p>
                                    <small class="text-muted">- {{ $topReview->user->name }}</small>
                                </div>
                            @endif
                            
                            <div class="mt-3 d-flex justify-content-center align-items-center">
                                <a href="{{ route('game.details', $game->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-play"></i> Play Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="empty-state">
                        <i class="fa fa-star-o fa-3x text-muted mb-3"></i>
                        <h4>No Top Rated Games Yet</h4>
                        <p class="text-muted">Games will appear here once they receive reviews from our community.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .rating-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 8px 12px;
        border-radius: 20px;
        text-align: center;
        backdrop-filter: blur(5px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }
    
    .rating-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    }
    
    .rating-number {
        font-size: 1.2em;
        font-weight: bold;
        display: block;
        margin-bottom: 2px;
        color: #ffc107;
    }
    
    .rating-badge .stars {
        font-size: 0.8em;
        margin-bottom: 2px;
    }
    
    .rating-badge .review-count {
        font-size: 0.7em;
        opacity: 0.8;
    }
    
    .review-snippet {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 12px;
        border-radius: 8px;
        border-left: 4px solid #ffc107;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        margin-top: 10px;
    }
    
    .review-snippet .stars {
        font-size: 0.8em;
    }
    
    .review-snippet p {
        font-style: italic;
        margin-bottom: 5px;
    }
    
    .empty-state {
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 15px;
        border: 2px dashed #dee2e6;
    }
    
    .empty-state i {
        color: #6c757d;
    }
    
    .item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .item .thumb {
        position: relative;
        overflow: hidden;
    }
    
    .item .thumb img {
        transition: transform 0.3s ease;
    }
    
    .item:hover .thumb img {
        transform: scale(1.05);
    }
    
    .item .down-content {
        padding: 20px;
        background: #f7f7f7;
        border-radius: 0 0 15px 15px;
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
    
    .section-heading h6 {
        color: #ffc107;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }
    
    .section-heading h2 {
        color: #333;
        font-weight: 700;
        margin-bottom: 30px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .rating-badge {
            padding: 6px 10px;
        }
        
        .rating-number {
            font-size: 1em;
        }
        
        .rating-badge .stars {
            font-size: 0.7em;
        }
        
        .review-snippet {
            padding: 10px;
        }
    }
</style> 