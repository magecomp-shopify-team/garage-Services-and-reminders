<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\JobCard;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['jobCard.customer', 'jobCard.vehicle']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('jobCard.customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $invoices = $query->latest()->paginate(10)->withQueryString();
        return view('user.invoices.index', compact('invoices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_card_id' => 'required|exists:job_cards,id',
        ]);

        $jobCard = JobCard::with(['services', 'parts'])->findOrFail($validated['job_card_id']);
        
        $servicesTotal = $jobCard->services->sum('total');
        $partsTotal = $jobCard->parts->sum('total');
        $subtotal = $servicesTotal + $partsTotal;
        $tax = $subtotal * 0.18; // Example 18% tax
        $total = $subtotal + $tax;

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . time(),
            'job_card_id' => $jobCard->id,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'paid_amount' => 0,
            'balance' => $total,
            'status' => 'Pending',
        ]);

        return redirect()->route('invoices.show', $invoice)->with('success', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['jobCard.customer', 'jobCard.vehicle', 'jobCard.services.service', 'jobCard.parts.sparePart', 'payments']);
        return view('user.invoices.show', compact('invoice'));
    }
}
