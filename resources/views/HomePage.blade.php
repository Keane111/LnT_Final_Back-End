<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - ChipiChapa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/Home.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-warning sticky-top">
        <div class="container">
            <a class="navbar-brand text-dark" href="#">
                <i class="fas fa-store me-2"></i>ChipiChapa
            </a>
            <div class="d-flex gap-2">
                <a href="/cart" class="btn btn-outline-dark">
                    <i class="fas fa-shopping-cart"></i>
                    Cart
                </a>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark">Logout</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-outline-dark">Login</a>
                @endauth
            </div>
        </div>
    </nav>

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
                                    <button class="btn cart-btn w-100">
                                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                    </button>
                                @endif
                            @else
                                <a href="/login" class="btn cart-btn w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login to Buy
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
