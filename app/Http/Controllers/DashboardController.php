<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyReport;
use App\Models\AmbulanceBilling;

class DashboardController extends Controller
{
    public function index()
    {
    $reports = EmergencyReport::latest()->get(); // if you already have this
    $billings = AmbulanceBilling::latest()->get(); // new line

    return view('dashboard', compact('reports', 'billings'));
    }
}
