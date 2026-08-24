<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index(Request $request)
    {
        $query = SparePart::query();
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }
        $spareParts = $query->paginate(10)->withQueryString();
        return view('admin.spare-parts.index', compact('spareParts'));
    }

    public function create()
    {
        return view('admin.spare-parts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_limit' => 'required|integer|min:0',
        ]);

        SparePart::create($validated);
        return redirect()->route('admin.spare-parts.index')->with('success', 'Spare Part created successfully.');
    }

    public function edit(SparePart $sparePart)
    {
        return view('admin.spare-parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'low_stock_limit' => 'required|integer|min:0',
        ]);

        $sparePart->update($validated);
        return redirect()->route('admin.spare-parts.index')->with('success', 'Spare Part updated successfully.');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();
        return redirect()->route('admin.spare-parts.index')->with('success', 'Spare Part deleted successfully.');
    }
}
