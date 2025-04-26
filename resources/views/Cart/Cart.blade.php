@extends('Layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Cart.css') }}">

<div class="container py-5">
    <h2 class="mb-4">Shopping Cart</h2>

    <div class="row">
        <div class="col-lg-8">
            <div class="cart-container">
                @if($cart_items->isEmpty())
                    <p class="text-center py-4">Your cart is empty</p>
                @else
                    @foreach($cart_items as $item)
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="{{ asset('storage/item_images/' . $item->item->photo) }}" alt="{{ $item->item->name }}" class="item-image">
                                </div>
                                <div class="col-md-4">
                                    <h5>{{ $item->item->name }}</h5>
                                    <p class="text-muted">Price: Rp {{ number_format($item->item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" min="1" value="{{ $item->quantity }}"
                                           class="form-control quantity-input"
                                           onchange="updateQuantity({{ $item->id }}, this.value)">
                                </div>
                                <div class="col-md-2">
                                    <p class="fw-bold">Rp {{ number_format($item->item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                                <div class="col-md-1">
                                    <button onclick="removeItem({{ $item->id }})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="checkout-form">
                <h4 class="mb-3">Order Summary</h4>
                <div class="d-flex justify-content-between mb-3">
                    <span>Total:</span>
                    <span class="cart-total">Rp {{ number_format($total, 2) }}</span>
                </div>

                @if(!$cart_items->isEmpty())
                    <form id="checkoutForm" onsubmit="checkout(event)">
                        @csrf
                        <div class="mb-3">
                            <label for="address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="postcode" class="form-label">Post Code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Proceed to Checkout</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function updateQuantity(itemId, quantity) {
    fetch(`/cart/update/${itemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if(data.message === 'Cart updated successfully') {
            window.location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function removeItem(itemId) {
    if(confirm('Are you sure you want to remove this item?')) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.message === 'Item removed from cart') {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

function checkout(event) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch('/cart/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            address: formData.get('address'),
            postcode: formData.get('postcode')
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.invoice_id) {
            window.location.href = `/invoices/${data.invoice_id}`;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
