<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    public function index(Request $request)
    {
        $doctors = Doctor::with(['department', 'schedulings' => function ($query) {
            $query->orderBy('day', 'asc')->orderBy('time', 'asc');
        }]);
        if ($request->wantsJson()) {
            if ($request->name) {
                $doctors = $doctors->orWhere('name', 'like', '%' . $request->name . '%');
            }
            if ($request->department) {
                $doctors = $doctors->orWhere('department_id', $request->department);
            }
            $doctors = $doctors->whereHas('schedulings', function ($query) use ($request) {
                $query = $query->orderBy('day', 'asc')->orderBy('time', 'asc');
                if ($request->day && $request->time) {
                    $query = $query->where('day', $request->day)->where('time', $request->time);
                } elseif ($request->day) {
                    $query = $query->where('day', $request->day);
                } else {
                    $query = $query->where('dtimeay', $request->time);
                }
            });
            $doctors = $doctors->latest()->get();
            return $doctors;
        }

        $doctors = $doctors->where('status', 1)->latest()->get();
        $departments = Department::latest()->get();

        return view('pc.scheduling.index', compact('doctors', 'departments'));
    }
}
