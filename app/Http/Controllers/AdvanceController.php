<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Scheduling;

class AdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $schedulings = Scheduling::with('doctor.department')->whereHas('doctor')
                        ->orderBy('type', 'asc')
                        ->orderBy('day', 'asc')
                        ->orderBy('time', 'asc')
                        ->get();
        return view('mobile.advances.index', compact('schedulings'));
    }
}
