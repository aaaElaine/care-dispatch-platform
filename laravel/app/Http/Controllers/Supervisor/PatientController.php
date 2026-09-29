<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return Patient::with('supervisor')->orderByDesc('id')->get();
    }

    public function show(Patient $patient)
    {
        return $patient->load('carePlans');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string',
            'emergency_contact_phone' => 'nullable|string',
        ]);
        $data['supervisor_id'] = $request->user()->id;
        return Patient::create($data);
    }
}
