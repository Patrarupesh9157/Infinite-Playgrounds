<div class="section trending">
    <div class="container">
        <ul class="trending-filter">
            <li>
                <a class="is_active" href="#!" data-filter="*">Show All</a>
            </li>
            <li>
                <a href="#!" data-filter=".adv">Adventure</a>
            </li>
            <li>
                <a href="#!" data-filter=".str">Strategy</a>
            </li>
            <li>
                <a href="#!" data-filter=".rac">Racing</a>
            </li>
        </ul>

        <div class="row trending-box">
            @foreach($products as $product)
            <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 {{ $product->categories }}">
                <div class="item">
                    <div class="thumb">
                        <a href="{{ route('product.details', $product->id) }}">
                            <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}">
                        </a>
                        <span class="price">
                            @if($product->original_price > $product->price)
                                <em>${{ $product->original_price }}</em>
                            @endif
                            ${{ $product->price }}
                        </span>
                    </div>
                    <div class="down-content">
                        <span class="category">{{ $product->category }}</span>
                        <h4>{{ $product->name }}</h4>
                        <a href="{{ route('product.details', $product->id) }}">
                            <i class="fa fa-shopping-bag"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{ $products->links('sections.shop.pagination') }}
    </div>
</div>