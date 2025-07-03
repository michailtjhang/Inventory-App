<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        // fetch items from the database
        $items = Item::all();

        // Return the items to the inendex view
        return inertia('Items/Index', [
            'items' => $items,
        ]);
    }

    public function create()
    {
        // Return the create item view
        return inertia('Items/Create');
    }

    public function store(Request $request)
    {
        // validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer|digits_between:1,6',
        ]);

        // create a new item
        Item::create($request->all());

        // redirect to the items index page
        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function show($id)
    {
        // Logic to display a specific item
    }

    public function edit($id)
    {
        // Logic to show form for editing an existing item
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing item
    }

    public function destroy($id)
    {
        // Logic to delete an item
    }
}
