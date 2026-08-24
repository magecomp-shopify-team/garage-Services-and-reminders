@extends('layouts.admin')

@section('header', 'Invoice: ' . $invoice->invoice_number)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>{{ $invoice->jobCard->customer->name }}</strong>
                        </div>
                        <div>{{ $invoice->jobCard->customer->address }}</div>
                        <div>{{ $invoice->jobCard->customer->city }}</div>
                        <div>Phone: {{ $invoice->jobCard->customer->mobile }}</div>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="mb-3">Vehicle Details:</h6>
                        <div>
                            <strong>{{ $invoice->jobCard->vehicle->registration_number }}</strong>
                        </div>
                        <div>{{ $invoice->jobCard->vehicle->brand }} {{ $invoice->jobCard->vehicle->model }}</div>
                        <div>Job Card: {{ $invoice->jobCard->job_number }}</div>
                    </div>
                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Type</th>
                                <th class="right">Unit Cost</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->jobCard->services as $service)
                            <tr>
                                <td>{{ $service->service->name ?? 'Service' }}</td>
                                <td>Service</td>
                                <td class="right">₹{{ $service->price }}</td>
                                <td class="center">{{ $service->quantity }}</td>
                                <td class="right">₹{{ $service->total }}</td>
                            </tr>
                            @endforeach
                            @foreach($invoice->jobCard->parts as $part)
                            <tr>
                                <td>{{ $part->sparePart->name ?? 'Part' }}</td>
                                <td>Spare Part</td>
                                <td class="right">₹{{ $part->price }}</td>
                                <td class="center">{{ $part->quantity }}</td>
                                <td class="right">₹{{ $part->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5 ms-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left"><strong>Subtotal</strong></td>
                                    <td class="right">₹{{ $invoice->subtotal }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Tax (18%)</strong></td>
                                    <td class="right">₹{{ $invoice->tax }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Total</strong></td>
                                    <td class="right"><strong>₹{{ $invoice->total }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Paid</strong></td>
                                    <td class="right text-success">₹{{ $invoice->paid_amount }}</td>
                                </tr>
                                <tr>
                                    <td class="left"><strong>Balance</strong></td>
                                    <td class="right text-danger"><strong>₹{{ $invoice->balance }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Record Payment</div>
            <div class="card-body">
                @if($invoice->balance > 0)
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <div class="mb-3">
                        <label>Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control" max="{{ $invoice->balance }}" value="{{ $invoice->balance }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Payment Method</label>
                        <select name="payment_method" class="form-control" required>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Date</label>
                        <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add Payment</button>
                </form>
                @else
                <div class="alert alert-success">This invoice is fully paid.</div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">Payment History</div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($invoice->payments as $payment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>₹{{ $payment->amount }}</strong><br>
                            <small class="text-muted">{{ $payment->payment_method }} - {{ $payment->payment_date }}</small>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center">No payments recorded</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
