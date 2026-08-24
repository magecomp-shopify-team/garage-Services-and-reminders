<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    public function index()
    {
        $mechanics = Mechanic::paginate(10);
        return view('admin.mechanics.index', compact('mechanics'));
    }

    public function create()
    {
        return view('admin.mechanics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        Mechanic::create($validated);
        return redirect()->route('admin.mechanics.index')->with('success', 'Mechanic added successfully.');
    }

    public function edit(Mechanic $mechanic)
    {
        return view('admin.mechanics.edit', compact('mechanic'));
    }

    public function update(Request $request, Mechanic $mechanic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        $mechanic->update($validated);
        return redirect()->route('admin.mechanics.index')->with('success', 'Mechanic updated successfully.');
    }

    public function destroy(Mechanic $mechanic)
    {
        $mechanic->delete();
        return redirect()->route('admin.mechanics.index')->with('success', 'Mechanic deleted successfully.');
    }
}
