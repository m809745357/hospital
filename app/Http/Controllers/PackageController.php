<?php

namespace App\Http\Controllers;

use App\Models\Package;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $packages = Package::all();
        return view('mobile.packages.index', compact('packages'));
    }

    public function show(Package $package)
    {
        return view('mobile.packages.show', compact('package'));
    }
}
