@extends('Layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/Cart.css') }}">

<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Invoice Details</h4>
                    <p class="mb-1"><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                    <p class="mb-1"><strong>Customer:</strong> {{ $invoice->user->name }}</p>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Shipping Address</h4>
                    <p class="mb-1">{{ $invoice->address }}</p>
                    <p class="mb-1">Post Code: {{ $invoice->postcode }}</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->invoiceItems as $item)
                    <tr class="invoice-item">
                        <td>{{ $item->name }}</td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-end">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="invoice-total">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span class="cart-total">Rp {{ number_format($invoice->tot_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
