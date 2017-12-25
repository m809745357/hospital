<?php

namespace App\Http\Controllers;

use App\Models\Special;

class SpecialController extends Controller
{
    /**
     * 医疗动态列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specials = Special::where('status', 1)->latest()->get();
        return view('pc/special/index', compact('specials'));
    }

    /**
     * 医疗动态详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Special $special)
    {
        if ($special->status !== 1) {
            return redirect()->back();
        }

        return view('pc/special/show', compact('special'));
    }
}
