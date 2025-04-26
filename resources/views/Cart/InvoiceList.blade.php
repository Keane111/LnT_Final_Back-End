@extends('Layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Cart.css') }}">

<div class="container py-5">
    <h2 class="mb-4">My Orders</h2>

    <div class="row">
        <div class="col-12">
            @if($invoices->isEmpty())
                <div class="invoice-container">
                    <p class="text-center py-4">No orders found</p>
                </div>
            @else
                @foreach($invoices as $invoice)
                    <div class="invoice-container mb-3">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="text-muted mb-1">Order ID:</p>
                                <p class="fw-bold">{{ $invoice->invoice_number }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1">Date:</p>
                                <p>{{ $invoice->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="text-muted mb-1">Total:</p>
                                <p class="cart-total">Rp {{ number_format($invoice->tot_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-3 text-end">
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-warning">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
