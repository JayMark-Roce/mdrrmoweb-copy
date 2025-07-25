<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ambulance;

class GpsUpdateController extends Controller
{
    public function update(Request $request)
    {
        $ambulance = Ambulance::find($request->id);

        if ($ambulance) {
            $ambulance->latitude = $request->latitude;
            $ambulance->longitude = $request->longitude;
            $ambulance->save();

            return response()->json(['message' => 'Location updated']);
        }

        return response()->json(['error' => 'Ambulance not found'], 404);
    }
}
