<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Ambulance;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('ambulance')->get();
        $ambulances = Ambulance::all();

        return view('admin.drivers.index', compact('drivers', 'ambulances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:drivers,email',
            'password' => 'required|min:6',
            'ambulance_id' => 'nullable|exists:ambulances,id',
        ]);

        Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ambulance_id' => $request->ambulance_id,
        ]);

        return back()->with('success', 'Driver created successfully!');
    }
}
