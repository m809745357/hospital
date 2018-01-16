<?php

namespace App\Http\Controllers;

use App\Models\Dynamic;

class DynamicController extends Controller
{
    /**
     * 医疗动态列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dynamics = Dynamic::where('status', 1)->latest()->get();
        return view('pc/dynamic/index', compact('dynamics'));
    }

    /**
     * 医疗动态详情
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Dynamic $dynamic)
    {
        if ($dynamic->status !== 1) {
            return redirect()->back();
        }
        $dynamic->increment('click_num');
        return view('pc/dynamic/show', compact('dynamic'));
    }
}
