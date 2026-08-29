<?php
namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        return response()->json(
            MenuItem::with('category')->orderBy('name')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:150',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'is_available' => 'sometimes|boolean',
        ]);
        $item = MenuItem::create($data);
        return response()->json($item->load('category'), 201);
    }

    public function show(MenuItem $menuItem)
    {
        return response()->json($menuItem->load('category'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'category_id'  => 'sometimes|exists:categories,id',
            'name'         => 'sometimes|string|max:150',
            'description'  => 'nullable|string',
            'price'        => 'sometimes|numeric|min:0',
            'is_available' => 'sometimes|boolean',
        ]);
        $menuItem->update($data);
        return response()->json($menuItem->load('category'));
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return response()->json(['message' => 'Item deleted.']);
    }
}
