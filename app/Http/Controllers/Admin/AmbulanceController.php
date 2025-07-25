<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambulance;

class AmbulanceController extends Controller
{
    public function index()
    {
        $ambulances = Ambulance::all();
        return view('admin.ambulances.index', compact('ambulances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:ambulances,name',
            'status' => 'required|in:Available,Out,Unavailable'
        ]);

        Ambulance::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return back()->with('success', 'Ambulance added successfully!');
    }
}
