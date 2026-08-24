<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with('customer');
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }
        $vehicles = $query->paginate(10)->withQueryString();
        return view('user.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('user.vehicles.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'registration_number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'fuel_type' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'current_km' => 'nullable|integer',
            'chassis_number' => 'nullable|string|max:255',
        ]);

        Vehicle::create($validated);
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created successfully.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['customer', 'jobCards']);
        return view('user.vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $customers = Customer::all();
        return view('user.vehicles.edit', compact('vehicle', 'customers'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'registration_number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|string|max:10',
            'fuel_type' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'current_km' => 'nullable|integer',
            'chassis_number' => 'nullable|string|max:255',
        ]);

        $vehicle->update($validated);
        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
