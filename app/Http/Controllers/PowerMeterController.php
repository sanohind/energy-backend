<?php

namespace App\Http\Controllers;

use App\Models\PowerMeter;
use Illuminate\Http\Request;

class PowerMeterController extends Controller
{
    public function index()
    {
        $powerMeters = PowerMeter::orderBy('name', 'asc')->get();
        return response()->json($powerMeters);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slave_id' => 'required|integer|unique:power_meters',
            'name' => 'required|string|max:100',
            'max_voltage' => 'nullable|numeric',
            'max_current' => 'nullable|numeric',
            'max_power' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        $meter = PowerMeter::create($validated);
        return response()->json(['status' => 'success', 'data' => $meter], 201);
    }

    public function update(Request $request, $id)
    {
        $powerMeter = PowerMeter::findOrFail($id);
        $validated = $request->validate([
            'slave_id' => 'required|integer|unique:power_meters,slave_id,' . $powerMeter->id,
            'name' => 'required|string|max:100',
            'max_voltage' => 'nullable|numeric',
            'max_current' => 'nullable|numeric',
            'max_power' => 'nullable|numeric',
            'is_active' => 'boolean',
        ]);

        $powerMeter->update($validated);
        return response()->json(['status' => 'success', 'data' => $powerMeter]);
    }

    public function destroy($id)
    {
        $powerMeter = PowerMeter::findOrFail($id);
        $powerMeter->delete();
        return response()->json(['status' => 'success', 'message' => 'Power meter deleted successfully.']);
    }
}