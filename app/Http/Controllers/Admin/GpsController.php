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
}
