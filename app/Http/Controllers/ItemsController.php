<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Category;
use Illuminate\Http\Request;


class ItemsController extends Controller
{
    function getItemPage()
    {
        $items = Items::all();
        return view('items.index', compact('items'));
    }

    function getCreatePage()
    {
        $categories = Category::all();
        return view('Item/create', compact('categories'));
    }

    function createItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:5|max:80',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'photo' => 'required',
        ],[
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 5 characters',
            'name.max' => 'Name must not exceed 80 characters',
            'category_id.required' => 'Category is required',
            'category_id.exists' => 'Category does not exist',
            'price.required' => 'Price is required',
            'quantity.required' => 'Quantity is required',
            'photo.required' => 'Photo is required',
        ]);

        $filename = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('item_images', $filename, 'public');

        $item = Items::create([
            'name' => $request->input('name'),
            'category_id' => $request->input('category_id'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'photo' => $filename,
        ]);

        return redirect()->back()->with('success', 'Item created successfully!');
    }

    function deleteItem($id)
    {
        $item = Items::findOrFail($id);
        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }

    function getEditItem($id)
    {
        $item = Items::findOrFail($id);
        // $categories = Category::all();
        return view('items.edit', compact('item'));
    }

    function editItem(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'photo' => 'nullable|image|max:2048',
        ],[
            'name.required' => 'Name is required',
            'name.max' => 'Name must not exceed 255 characters',
            'category_id.required' => 'Category is required',
            'price.required' => 'Price is required',
            'quantity.required' => 'Quantity is required',
            'photo.image' => 'Photo must be an image',
            'photo.max' => 'Photo must not exceed 2MB',
        ]);

        $item = Items::findOrFail($id);
        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'photo' => $request->hasFile('photo') ? $request->file('photo')->storeAs('item_images', time() . '_' . $request->file('photo')->getClientOriginalName(), 'public') : $item->photo,
        ]);

        return redirect()->back()->with('success', 'Item updated successfully!');
    }

    }
    function updateItem(Request $request, $id)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'photo' => 'nullable|image|max:2048',
    ]);

    $item = Items::findOrFail($id);
    $item->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'quantity' => $request->quantity,
        'photo' => $request->hasFile('photo') ? $request->file('photo')->storeAs('item_images', time() . '_' . $request->file('photo')->getClientOriginalName(), 'public') : $item->photo,
    ]);

    return redirect()->back()->with('success', 'Item updated successfully!');
}