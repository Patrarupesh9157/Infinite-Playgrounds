@extends('layouts.app')

@section('content')
<style>
    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        transition: transform 0.2s;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        object-fit: cover;
        height: 200px;
        cursor: pointer;
    }

    .icon-button {
        display: inline-block;
        cursor: pointer;
    }

    .view-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        display: none;
        color: #fff;
        border-radius: 50%;
        padding: 5px;
    }

    .card:hover .view-icon {
        display: block;
    }
    .disabled-button {
        cursor: not-allowed;
        opacity: 0.6;
    }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Products</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
    </div>

    <!-- Filter Form -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="sort_by" class="form-control" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                    <option value="name_desc" {{ request('sort_by') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                    <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price Low to High</option>
                    <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price High to Low</option>
                </select>
            </div>
        </div>
    </form>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                @php
                $images = json_decode($product->images);
                $firstImage = $images[0];
                @endphp
                <div onclick="window.location='{{ route('products.show', $product->id) }}'">
                    <img src="{{ asset('images/product/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="view-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text"><strong>Price:</strong> ₹{{ $product->price }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.edit', $product->id) }}" class="icon-button" title="Edit">
                            <i class="fas fa-edit text-warning"></i>
                        </a>
                        <a href="{{ route('products.addToCart', $product->id) }}" class="icon-button {{ in_array($product->id, $productIdsInCart) ? 'disabled-button' : '' }}" title="Add to Cart" 
                           {{ in_array($product->id, $productIdsInCart) ? 'aria-disabled="true"' : '' }}>
                            <i class="fas fa-shopping-cart {{ in_array($product->id, $productIdsInCart) ? 'text-secondary' : 'text-success' }}"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="icon-button" onsubmit="return confirm('Are you sure you want to delete this product?');" title="Delete">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button" style="background: none; border: none; padding: 0;">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
