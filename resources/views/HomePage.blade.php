@extends('Layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col">
            <h2 class="text-dark mb-0">Our Products</h2>
        </div>
        @auth
            @if(auth()->user()->role === 'admin')
                <div class="col text-end">
                    <a href="{{ route('add-item') }}" class="btn cart-btn">
                        <i class="fas fa-plus me-2"></i>Add New Item
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <div class="row g-4">
        @foreach($items as $item)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="product-card">
                    <img src="{{ asset('storage/item_images/' . $item->photo) }}"
                         alt="{{ $item->name }}"
                         class="w-100 product-image">
                    <div class="product-info">
                        <h5 class="mb-2">{{ $item->name }}</h5>
                        <p class="product-price mb-2">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-muted mb-3">Stock: {{ $item->quantity }}</p>

                        @auth
                            @if(auth()->user()->role === 'admin')
                                <div class="d-flex gap-2">
                                    <a href="{{ route('edit-item', $item->id) }}"
                                       class="btn btn-warning flex-grow-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('items.delete', $item->id) }}"
                                          method="POST"
                                          class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <button onclick="addToCart({{ $item->id }})" class="btn cart-btn w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn cart-btn w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function addToCart(itemId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            item_id: itemId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.message === 'Item added to cart') {
            alert('Item added to cart successfully!');
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
