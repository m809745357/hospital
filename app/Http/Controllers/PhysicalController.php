<?php

namespace App\Http\Controllers;

use App\Models\Physical;
use App\Models\Department;

class PhysicalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $physicals = Department::with('physical')->get();
        return view('mobile.physicals.index', compact('physicals'));
    }
}
