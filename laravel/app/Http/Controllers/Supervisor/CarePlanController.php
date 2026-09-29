<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\CarePlan;
use Illuminate\Http\Request;

class CarePlanController extends Controller
{
    public function index()
    {
        return CarePlan::with(['patient', 'serviceItem'])->orderByDesc('id')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required|integer',
            'service_item_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'frequency' => 'nullable|string',
            'duration_minutes' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);
        $data['status'] = 'active';
        return CarePlan::create($data);
    }
}
