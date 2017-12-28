<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePromoterPost;
use App\Http\Requests\CreatePromoterOrderUpdate;
use App\Models\PromoterOrder;
use App\Models\PromoterRecord;
use App\Models\Config;

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
        $promoterOrders = auth()->user()->promoter->load(['order' => function ($query) {
            $query->orderBy('status', 'asc');
        }, 'order.department']);
        return view('mobile.promoters.order', compact('promoterOrders'));
    }

    public function confirm()
    {
        $promoterRecords = auth()->user()->statistics;
        return view('mobile.promoters.confirm', compact('promoterRecords'));
    }

    public function record()
    {
        $promoterRecords = auth()->user()->promoter->load('order.record', 'order.department');

        $info = \DB::select('select sum(crown) as crown, sum(stars) as stars from promoter_orders as a join promoter_records as b on a.id = b.promoter_order_id where promoter_id = :promoter_id and MONTH(a.created_at) = MONTH(NOW())', ['promoter_id' => auth()->user()->promoter->id]);
        $message = json_encode($info);
        return view('mobile.promoters.record', compact('promoterRecords', 'message'));
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
        $promoterOrders = auth()->user()->promoterOrder()->with('department', 'record')->latest()->get();
        return view('mobile.promoters.order', compact('promoterOrders'));
    }

    public function update(CreatePromoterOrderUpdate $request)
    {
        $promoterOrder = PromoterOrder::find($request->id);

        if (!Config::where(['slug' => 'secret', 'contact' => $request->secret])->exists()) {
            return response(['data' => '请输入正确的兑换密码'], 400);
        }

        $promoterOrder->addRecord([
            'status' => '0'
        ]);

        $promoterOrder->update([
            'status' => 1
        ]);

        return response(['data' => '兑换成功'], 201);
    }
}
