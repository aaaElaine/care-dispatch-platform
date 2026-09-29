<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        return Assignment::with(['carePlan.patient', 'assignedToUser'])->orderByDesc('id')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'care_plan_id' => 'required|integer',
            'assigned_to_user_id' => 'required|integer',
            'scheduled_start_at' => 'required|date',
            'scheduled_end_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        $data['status'] = 'scheduled';
        $data['is_confirmed'] = false;
        return Assignment::create($data);
    }
}
