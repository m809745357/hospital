<?php

namespace App\Http\Controllers;

use App\Models\Dynamic;
use Illuminate\Http\Request;

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
        return view('pc.home', compact('dynamics'));
    }

    /**
     * 医院介绍页面
     *
     * @return \Illuminate\Http\Response
     */
    public function introduce()
    {
        return view('pc.introduce');
    }

    public function report()
    {
        return view('pc.report');
    }

    public function contact()
    {
        return view('pc.contact');
    }

    public function upload(Request $request)
    {
        $path = \Storage::disk('admin')->putFile('wangEditor', $request->file('nbyzgc'));

        return config('filesystems.disks.admin.url') . '/' . $path;
    }
}
