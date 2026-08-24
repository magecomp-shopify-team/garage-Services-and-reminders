<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('invoice')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($validated['invoice_id']);

        if ($validated['amount'] > $invoice->balance) {
            return redirect()->back()->with('error', 'Payment amount cannot exceed the balance.');
        }

        Payment::create($validated);

        // Update Invoice
        $invoice->paid_amount += $validated['amount'];
        $invoice->balance -= $validated['amount'];
        
        if ($invoice->balance <= 0) {
            $invoice->status = 'Paid';
        } else {
            $invoice->status = 'Partial';
        }
        
        $invoice->save();

        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }
}
