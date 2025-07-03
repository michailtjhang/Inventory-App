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
        // Logic to show form for creating a new item
    }

    public function store(Request $request)
    {
        // Logic to store a new item
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
