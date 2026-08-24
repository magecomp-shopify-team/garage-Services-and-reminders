@extends('layouts.admin')

@section('header', 'Manage Job Card: ' . $jobCard->job_number)

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">Job Card Details</div>
            <div class="card-body">
                <form action="{{ route('admin.job-cards.updateStatus', $jobCard) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            @foreach(['Pending', 'Inspection', 'Assigned', 'In Progress', 'Waiting for Parts', 'Completed', 'Ready for Delivery', 'Delivered', 'Cancelled'] as $status)
                                <option value="{{ $status }}" {{ $jobCard->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <hr>
                <p><strong>Customer:</strong> {{ $jobCard->customer->name }} ({{ $jobCard->customer->mobile }})</p>
                <p><strong>Vehicle:</strong> {{ $jobCard->vehicle->registration_number }} - {{ $jobCard->vehicle->brand }}</p>
                <p><strong>Mechanic:</strong> {{ $jobCard->mechanic->name ?? 'Not Assigned' }}</p>
                <p><strong>Complaint:</strong> {{ $jobCard->complaint }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">Services</div>
            <div class="card-body">
                <form action="{{ route('admin.job-cards.addService', $jobCard) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <select name="service_id" class="form-control" required>
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }} (₹{{ $service->price }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Add Service</button>
                    </div>
                </form>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $servicesTotal = 0; @endphp
                        @foreach($jobCard->services as $jcService)
                        <tr>
                            <td>{{ $jcService->service->name ?? 'N/A' }}</td>
                            <td>₹{{ $jcService->price }}</td>
                            @php $servicesTotal += $jcService->price; @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <th>Total Services</th>
                            <th>₹{{ $servicesTotal }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Spare Parts</div>
            <div class="card-body">
                <form action="{{ route('admin.job-cards.addPart', $jobCard) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-8">
                            <select name="spare_part_id" class="form-control" required>
                                <option value="">Select Part</option>
                                @foreach($parts as $part)
                                    <option value="{{ $part->id }}">{{ $part->name }} (Stock: {{ $part->stock }}, ₹{{ $part->selling_price }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Add Part</button>
                        </div>
                    </div>
                </form>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Part</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $partsTotal = 0; @endphp
                        @foreach($jobCard->parts as $jcPart)
                        <tr>
                            <td>{{ $jcPart->sparePart->name ?? 'N/A' }}</td>
                            <td>{{ $jcPart->quantity }}</td>
                            <td>₹{{ $jcPart->price }}</td>
                            <td>₹{{ $jcPart->total }}</td>
                            @php $partsTotal += $jcPart->total; @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">Total Parts</th>
                            <th>₹{{ $partsTotal }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body text-end">
                <h4>Grand Total: ₹{{ $servicesTotal + $partsTotal }}</h4>
                @if($jobCard->status == 'Completed' && $jobCard->invoices->isEmpty())
                <form action="{{ route('admin.invoices.store', ['job_card_id' => $jobCard->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mt-2">Generate Invoice</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
