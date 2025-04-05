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
        $cart = Cart::where('user_id', Auth::id())->get();
        return response()->json($cart);
    }

    public function updateCart(Request $request, $id)
    {
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
        $item = Items::findOrFail($request->input('item_id'));

        $cart = new Cart();
        $cart->user_id = Auth::id();
        $cart->item_id = $item->id;
        $cart->quantity = $request->input('quantity');
        $cart->save();

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

    public function checkOut()
    {
        $cartItems = Cart::where('user_id', Auth::id())->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $invoice = new Invoice();
        $invoice->user_id = Auth::id();
        $invoice->invoice_number = Str::uuid();
        $invoice->save();

        foreach ($cartItems as $cartItem) {
            $invoiceItem = new InvoiceItem();
            $invoiceItem->invoice_id = $invoice->id;
            $invoiceItem->item_id = $cartItem->item_id;
            $invoiceItem->quantity = $cartItem->quantity;
            $invoiceItem->save();
        }

        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Checkout successful', 'invoice_id' => $invoice->id]);
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::with('items')->where('id', $id)->where('user_id', Auth::id())->first();
        if ($invoice) {
            return response()->json($invoice);
        }
        return response()->json(['message' => 'Invoice not found or unauthorized'], 404);
    }

    public function getInvoices()
    {
        $invoices = Invoice::where('user_id', Auth::id())->get();
        return response()->json($invoices);
    }

    
}
