<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockCard;
use Illuminate\Http\Request;
use Tighten\Ziggy\Output\Types;

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
            'qty'  => 'required|integer|digits_between:1,6',
            'unit' => 'required|string|max:100',
        ]);

        // create a new item
        Item::create($request->all());

        // redirect to the items index page
        return redirect()->route('items.index')->with('success', 'Item created successfully.');
    }

    public function edit($id)
    {
        // find the item by id
        $item = Item::findOrFail($id);

        // return the edit view with the item data
        return inertia('Items/Edit', [
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        // validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:100',
        ]);

        // find the item by id
        $item = Item::findOrFail($id);

        // update the item
        $item->update($request->all());

        // redirect to the items index page
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function editStock($id)
    {
        // find the item by id
        $item = Item::findOrFail($id);

        // return the edit stock view with the item data
        return inertia('Items/EditStock', [
            'item' => $item,
        ]);
    }

    public function updateStock(Request $request, $id)
    {
        // validate the request data
        $request->validate([
            'qty' => 'required|integer|digits_between:1,6',
            'note' => 'required|in:in,out',
        ]);

        // find the item by id
        $item = Item::findOrFail($id);

        // update the stock quantity
        if ($request->note === 'in') {
            $item->increment('qty', $request->qty); // increase quantity
        } elseif ($request->note === 'out') {
            if ($item->qty < $request->qty) {
                // Return validation error instead of redirect
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'qty' => ['Stok tidak mencukupi. Stok tersedia: ' . $item->qty . ' ' . $item->unit . ', diminta: ' . $request->qty . ' ' . $item->unit]
                    ]
                ], 422);
            } else {
                $item->decrement('qty', $request->qty); // decrease quantity
            }
        } else {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => [
                    'note' => ['Operasi stok tidak valid.']
                ]
            ], 422);
        }

        // update stock card
        StockCard::create([
            'item_id' => $item->id,
            'qty' => $request->qty,
            'note' => $request->note,
            'description' => $request->description ?? null,
        ]);

        // redirect to the items index page
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    public function viewStockCard($id)
    {
        // find the item by id
        $item = Item::findOrFail($id)->loadMissing('stockCards');

        // return the edit stock view with the item data
        return inertia('Items/StockCard', [
            'item' => $item,
        ]);
    }
}
