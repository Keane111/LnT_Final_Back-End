<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Items;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function viewCart()
    {
        $cart_items = Cart::with('item')->where('user_id', Auth::id())->get();
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->item->price * $item->quantity;
        }
        return view('Cart.Cart', compact('cart_items', 'total'));
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::find($id);
        if ($cart && $cart->user_id == Auth::id()) {
            $cart->quantity = $request->input('quantity');
            $cart->save();
            return response()->json(['message' => 'Cart updated successfully']);
        }
        return response()->json(['message' => 'Cart not found or unauthorized'], 404);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $item = Items::findOrFail($request->input('item_id'));

        // Check if item already exists in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('item_id', $item->id)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $request->input('quantity');
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'item_id' => $item->id,
                'quantity' => $request->input('quantity')
            ]);
        }

        return response()->json(['message' => 'Item added to cart']);
    }

    public function removeFromCart($id)
    {
        $cart = Cart::find($id);
        if ($cart && $cart->user_id == Auth::id()) {
            $cart->delete();
            return response()->json(['message' => 'Item removed from cart']);
        }
        return response()->json(['message' => 'Cart not found or unauthorized'], 404);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'postcode' => 'required|string'
        ]);

        $cartItems = Cart::with('item')->where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $totalAmount = 0;
        foreach ($cartItems as $cartItem) {
            $totalAmount += $cartItem->item->price * $cartItem->quantity;
        }

        $invoice = new Invoice();
        $invoice->user_id = Auth::id();
        $invoice->invoice_number = 'INV-' . Str::random(10);
        $invoice->address = $request->address;
        $invoice->postcode = $request->postcode;
        $invoice->tot_amount = $totalAmount;
        $invoice->save();

        foreach ($cartItems as $cartItem) {
            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->item_id = $cartItem->item_id;
            $invoiceItem->name = $cartItem->item->name;
            $invoiceItem->quantity = $cartItem->quantity;
            $invoiceItem->price = $cartItem->item->price;
            $invoiceItem->save();
        }

        Cart::where('user_id', Auth::id())->delete();
        return response()->json([
            'message' => 'Checkout successful',
            'invoice_id' => $invoice->id
        ]);
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::with(['invoiceItems', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('Cart.InvoiceDetail', compact('invoice'));
    }

    public function getInvoices()
    {
        $invoices = Invoice::with('invoiceItems')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Cart.InvoiceList', compact('invoices'));
    }
}
