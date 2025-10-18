<?php

namespace App\Http\Controllers;

use App\Models\UserVisit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        return view('stopwatch');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'device_type' => 'required|string',
            'user_agent' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'time_of_visit' => 'required|date',
            'time_spent' => 'required|integer',
        ]);

        $data['ip_address'] = $request->ip();

        UserVisit::create($data);

        return response()->json(['message' => 'Visit recorded successfully']);
    }
}
