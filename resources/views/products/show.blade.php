@extends('layouts.app')

@section('content')
<style>
    .product-detail-img {
        max-height: 400px;
        object-fit: cover;
        cursor: pointer;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
    .image-gallery img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }
    .image-gallery {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .image-gallery .thumbnail {
        flex: 1 1 calc(25% - 10px);
    }
    /* Add styles for the slider */
    .slider {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        z-index: 1000;
        padding: 20px;
    }
    .slider img {
        width: 100%;
        height: 100vh;
        object-fit: cover;
        border-radius: 10px;
    }
    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1001;
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 20px;
    }
    .slider-nav button {
        background-color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 20px;
        color: #333;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }
    .slider-nav .prev {
        left: 20px;
    }
    .slider-nav .next {
        right: 20px;
    }
    .close {
        top: 20px;
        right: 20px;
        font-size: 20px;
        cursor: pointer;
        width: 40px;
        height: 40px;
        background-color: #fff;
        color: #333;
        position: absolute;
        border-radius: 50%;
        transform:  translateY(-50%);;
    }
    .slider-content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .slider-content img {
        max-width: 80%;
        max-height: 80vh;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container mt-4">
    <h1>Product Details</h1>
    <div class="row">
        <div class="col-md-8">
            @if($product->images && count(json_decode($product->images)) > 0)
                @php
                    $images = json_decode($product->images);
                    $firstImage = $images[0];
                @endphp
                <img src="{{ asset('storage/'. $firstImage) }}" class="img-fluid product-detail-img" alt="{{ $product->name }}" id="main-image">
                <div class="image-gallery mt-3">
                    @foreach($images as $image)
                        <div class="thumbnail">
                            <img src="{{ asset('storage/'. $image) }}" alt="Product Image">
                        </div>
                    @endforeach
                </div>
            @else
                <p>No images available for this product.</p>
            @endif
        </div>
        <div class="col-md-4">
            <h2>{{ $product->name }}</h2>
            <p><strong>Price:</strong> ₹{{ $product->price }}</p>
            <p><strong>Stitch:</strong> {{ $product->stitch }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $product->description }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
</div>

<!-- Add the slider container -->
<div class="slider" id="slider">
    <button class="close" id="slider-close">&times;</button>
    <div class="slider-nav">
        <button class="prev" onclick="prevImage()">&#10094;</button>
        <button class="next" onclick="nextImage()">&#10095;</button>
    </div>
    <div class="slider-content">
        @if($product->images && count(json_decode($product->images)) > 0)
        @foreach($images as $image)
            <img src="{{ asset('storage/'. $image) }}" alt="Product Image" class="slider-image">
        @endforeach
        @endif
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let currentIndex = 0;

        function showImage(index) {
            $('.slider-image').hide().eq(index).show();
            currentIndex = index;
        }

        $('#main-image, .image-gallery img').on('click', function() {
            const index = $(this).data('index') || 0;
            showImage(index);
            $('#slider').fadeIn();
        });

        $('.slider-nav .prev').on('click', function() {
            if (currentIndex > 0) {
                showImage(currentIndex - 1);
            }
        });

        $('.slider-nav .next').on('click', function() {
            if (currentIndex < $('.slider-image').length - 1) {
                showImage(currentIndex + 1);
            }
        });

        $('#slider-close, #slider').on('click', function(event) {
            if ($(event.target).is('#slider') || $(event.target).is('#slider-close')) {
                $('#slider').fadeOut();
            }
        });

        // Initialize the slider by showing the first image
        showImage(0);
    });
</script>
@endsection
