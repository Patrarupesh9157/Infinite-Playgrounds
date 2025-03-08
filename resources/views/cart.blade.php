@extends('layouts.app')

@section('content')
<style>
    .cart-item-card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        overflow: hidden;
        display: flex;
        align-items: center;
        padding: 15px;
        position: relative;
    }

    .cart-item-card img {
        border-radius: 10px;
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
    }

    .cart-item-card .item-details {
        flex-grow: 1;
        margin-left: 15px;
    }

    .cart-item-card .item-details h5 {
        margin: 0;
        font-size: 16px;
    }

    .cart-item-card .item-details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .cart-item-card .item-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .cart-item-card .item-actions .form-control {
        width: 100px;
    }

    .cart-item-card .item-actions .btn-danger {
        margin-top: 10px;
    }

    .cart-item-card .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fff;
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: background 0.2s, color 0.2s;
    }

    .cart-item-card .close-btn:hover {
        background: #f8f9fa;
    }

    .cart-item-card .close-btn i {
        color: #dc3545;
    }

    .total-price {
        font-size: 18px;
        font-weight: bold;
        margin-top: 20px;
        text-align: right;
    }
</style>

<div class="container">
    <h1 class="my-4">Your Cart</h1>
    @if ($cart && count($cart))
        <form id="cart-form" action="{{ route('cart.update') }}" method="POST">
            @csrf
            <div class="row">
                @php
                    $totalPrice = 0;
                @endphp
                @foreach ($cart as $productId => $item)
                    @php
                        $itemTotal = $item['price'] * $item['quantity'];
                        $totalPrice += $itemTotal;
                    @endphp
                    <div class="col-md-4 mb-4">
                        <div class="cart-item-card" data-product-id="{{ $productId }}">
                            @if (isset($item['images']))
                                @php
                                    $images = json_decode($item['images']);
                                    $firstImage = isset($images[0])
                                            ? 'storage/' . $images[0]
                                            : 'storage/product_images/suvidha-logo.png';
                                @endphp
                                <img src="{{ asset($firstImage) }}" alt="{{ $item['name'] }}"
                                    onclick="window.location='{{ route('products.show', $productId) }}'">
                            @endif
                            <div class="item-details">
                                <h5>{{ $item['name'] }}</h5>
                                <p>Price: ₹{{ number_format($item['price'], 2) }}</p>
                                <p>Total: ₹{{ number_format($itemTotal, 2) }}</p>
                                <input type="number" name="quantities[{{ $productId }}]"
                                    value="{{ $item['quantity'] }}" min="1"
                                    class="form-control quantity-input" data-product-id="{{ $productId }}">
                            </div>
                            <button type="button" class="close-btn" aria-label="Close" onclick="window.location='{{ route('cart.remove', $productId) }}'">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="total-price">
                Total Price: ₹<span id="total-price">{{ number_format($totalPrice, 2) }}</span>
            </div>
        </form>
    @else
        <div class="alert alert-info">
            Your cart is empty.
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        $('.quantity-input').on('change', function() {
            var $this = $(this);
            var productId = $this.data('product-id');
            var quantity = parseInt($this.val(), 10);

            if (quantity < 1) {
                toastr.warning('Quantity cannot be less than 1.');
                $this.val(1);
                return 0;
            } else {

                $.ajax({
                    url: '{{ route('cart.update') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        productId: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.message || 'An error occurred. Please try again.');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        toastr.error('An error occurred. Please try again.');
                    }
                });
            }
        });

    });
</script>
@endsection
