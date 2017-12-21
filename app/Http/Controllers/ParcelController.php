<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Ipad;

class ParcelController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Ipad $ipad)
    {
        $parcels = Channel::with('food')->get();
        return view('mobile.parcels.index', compact('parcels', 'ipad'));
    }
}
