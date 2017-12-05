<?php

namespace App\Http\Controllers;

use App\Models\Dynamic;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dynamics = Dynamic::latest('click_num')->take(4)->get();
        return view('home', compact('dynamics'));
    }

    /**
     * 医院介绍页面
     *
     * @return \Illuminate\Http\Response
     */
    public function introduce()
    {
        return view('introduce');
    }

    public function report()
    {
        return view('report');
    }

    public function contact()
    {
        return view('contact');
    }
}
