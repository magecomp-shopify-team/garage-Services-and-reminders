<?php

namespace App\Http\Controllers;

use App\Models\JobCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user() ? Auth::user()->role : 'Manager';
        $data = [];
        
        if ($role === 'Mechanic') {
            $data['assigned_jobs'] = JobCard::where('mechanic_id', Auth::id())->where('status', '!=', 'Completed')->count();
        }
        
        return view('dashboard', $data);
    }
}
