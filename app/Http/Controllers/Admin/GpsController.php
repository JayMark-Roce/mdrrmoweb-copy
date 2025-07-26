<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambulance;

class GpsController extends Controller
{
    public function index()
    {
        $ambulances = Ambulance::all();
        return view('admin.gps.index', compact('ambulances'));
    }

    public function setDestination(Request $request)
{
    $request->validate([
        'ambulance_id' => 'required|exists:ambulances,id',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $ambulance = Ambulance::find($request->ambulance_id);
    $ambulance->destination_latitude = $request->latitude;
    $ambulance->destination_longitude = $request->longitude;
    $ambulance->destination_updated_at = now();
    $ambulance->status = 'Out'; // 🧠 Set to Out automatically
    $ambulance->save();

    return response()->json(['message' => 'Destination set successfully.']);
}
}
