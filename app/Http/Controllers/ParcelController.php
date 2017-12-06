<?php

namespace App\Http\Controllers;

use App\Models\Channel;

class ParcelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $parcels = Channel::with('food')->get();
        return view('mobile.parcels.index', compact('parcels'));
    }
}
