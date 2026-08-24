<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\JobCard;
use App\Models\SparePart;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_customers' => Customer::count(),
            'total_vehicles' => Vehicle::count(),
            'pending_jobs' => JobCard::where('status', 'Pending')->count(),
            'in_progress_jobs' => JobCard::where('status', 'In Progress')->count(),
            'completed_jobs' => JobCard::where('status', 'Completed')->count(),
            'low_stock_parts' => SparePart::whereColumn('stock', '<=', 'low_stock_limit')->count(),
        ];
        
        return view('admin.dashboard', $data);
    }
}
