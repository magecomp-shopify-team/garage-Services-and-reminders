<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\JobCard;
use App\Models\Mechanic;
use App\Models\Service;
use App\Models\SparePart;
use App\Models\Vehicle;
use App\Models\JobCardService;
use App\Models\JobCardPart;
use Illuminate\Http\Request;

class JobCardController extends Controller
{
    public function index(Request $request)
    {
        $query = JobCard::with(['customer', 'vehicle', 'mechanic']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('job_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('vehicle', function($q) use ($search) {
                      $q->where('registration_number', 'like', "%{$search}%");
                  });
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $jobCards = $query->latest()->paginate(10)->withQueryString();
        return view('user.job-cards.index', compact('jobCards'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $mechanics = Mechanic::all();
        return view('user.job-cards.create', compact('customers', 'vehicles', 'mechanics'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'mechanic_id' => 'nullable|exists:mechanics,id',
            'complaint' => 'required|string',
            'current_km' => 'nullable|integer',
        ]);

        $validated['job_number'] = 'JC-' . time();
        $validated['status'] = 'Pending';
        $validated['received_date'] = now();

        $jobCard = JobCard::create($validated);
        
        return redirect()->route('job-cards.show', $jobCard)->with('success', 'Job Card created successfully.');
    }

    public function show(JobCard $jobCard)
    {
        $jobCard->load(['customer', 'vehicle', 'mechanic', 'services.service', 'parts.sparePart']);
        $services = Service::all();
        $parts = SparePart::all();
        
        return view('user.job-cards.show', compact('jobCard', 'services', 'parts'));
    }

    public function updateStatus(Request $request, JobCard $jobCard)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);

        if ($validated['status'] == 'Completed' && $jobCard->status != 'Completed') {
            $jobCard->completed_date = now();
        }

        $jobCard->update($validated);
        
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function addService(Request $request, JobCard $jobCard)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        $service = Service::find($request->service_id);
        
        JobCardService::create([
            'job_card_id' => $jobCard->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'price' => $service->price,
            'total' => $service->price,
        ]);

        return redirect()->back()->with('success', 'Service added successfully.');
    }

    public function addPart(Request $request, JobCard $jobCard)
    {
        $request->validate([
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $part = SparePart::find($request->spare_part_id);
        
        if ($part->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Insufficient stock for this part.');
        }
        
        $total = $part->selling_price * $request->quantity;

        JobCardPart::create([
            'job_card_id' => $jobCard->id,
            'spare_part_id' => $part->id,
            'quantity' => $request->quantity,
            'price' => $part->selling_price,
            'total' => $total,
        ]);
        
        $part->decrement('stock', $request->quantity);

        return redirect()->back()->with('success', 'Part added successfully.');
    }
}
