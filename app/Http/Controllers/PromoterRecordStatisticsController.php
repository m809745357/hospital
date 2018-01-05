<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoterRecordStatistics;
use App\Models\PromoterRecord;

class PromoterRecordStatisticsController extends Controller
{
    public function confirm(Request $request)
    {
        $statistics = PromoterRecordStatistics::find($request->statistics);
        if ($statistics->date === date("Y-m")) {
            return response(['data' => '无法兑换当前月份的奖励'], 400);
        }
        $statistics->update(['status' => 1]);
        $statistics->user->promoter->order->load('record')->each(function ($item) use ($statistics) {
            if (!is_null($item->record)) {
                $item->record->where('created_at', 'like', $statistics->date . '%')->update(['status' => 1]);
            }
        });
        return response(['data' => '兑换完成'], 201);
    }
}
