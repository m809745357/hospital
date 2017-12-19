<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromoterPost;

class PromoterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $promoter = auth()->user()->promoter;
        if (!$promoter) {
            return redirect('/promoter/create');
        }

        return view('mobile.promoters.show', compact('promoter'));
    }

    public function order()
    {
        $promoterOrders = auth()->user()->promoter->load('order.department');
        return view('mobile.promoters.order', compact('promoterOrders'));
    }

    public function confirm()
    {
        $promoterRecords = auth()->user()->promoter->load('order.record', 'order.department');
        return view('mobile.promoters.confirm', compact('promoterRecords'));
    }

    public function record()
    {
        $promoterRecords = auth()->user()->promoter->load('order.record', 'order.department');
        return view('mobile.promoters.record', compact('promoterRecords'));
    }

    public function create()
    {
        $promoter = auth()->user()->promoter;
        if ($promoter) {
            return redirect('/user/promoter');
        }
        return view('mobile.promoters.create');
    }

    public function store(CreatePromoterPost $request)
    {
        $promoter = auth()->user()->addPromoter($request->validated());

        return response(['data' => '推广信息完善成功'], 201);
    }

    public function promoter()
    {
        $promoterOrders = auth()->user()->promoterOrder->load('department');
        return view('mobile.promoters.order', compact('promoterOrders'));
    }
}
