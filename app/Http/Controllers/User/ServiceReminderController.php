<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ServiceReminder;
use Illuminate\Http\Request;

class ServiceReminderController extends Controller
{
    public function index()
    {
        $reminders = ServiceReminder::with(['customer', 'vehicle'])->orderBy('next_service_date')->paginate(10);
        return view('user.service-reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('user.service-reminders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'last_service_date' => 'nullable|date',
            'next_service_date' => 'required|date',
            'last_service_km' => 'nullable|integer',
            'next_service_km' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'Upcoming';
        
        ServiceReminder::create($validated);
        
        return redirect()->route('service-reminders.index')->with('success', 'Reminder created successfully.');
    }

    public function updateStatus(Request $request, ServiceReminder $serviceReminder)
    {
        $validated = $request->validate([
            'status' => 'required|in:Upcoming,Completed,Overdue,Sent',
        ]);

        if ($validated['status'] == 'Sent') {
            $serviceReminder->sent_at = now();
        }

        $serviceReminder->update($validated);
        
        return redirect()->route('service-reminders.index')->with('success', 'Status updated successfully.');
    }
}
