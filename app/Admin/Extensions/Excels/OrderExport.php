<?php

namespace App\Admin\Extensions\Excels;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Order;

class OrderExport extends AbstractExporter
{
    public function export()
    {
        Excel::create('订单导出', function ($excel) {
            $excel->sheet('点餐订单', function ($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $sheet->row(1, ['ID', '下单用户', '手机号码', '送餐地址', '订单详情', '订单价格', '订单编号', '订单备注', '订单时间', '支付方式', '订单状态', '下单时间']);
                $rows = Order::hydrate($this->getData())->load('user')->where('status', '>', 1)->where('order_details_type', 'App\\Models\\Food')->map(function ($item) {
                    return [
                        $item->id,
                        $item->user['name'],
                        $item->user['mobile'],
                        $item->user['address'],
                        $this->getOrderDetials($item),
                        $item->money,
                        $item->out_trade_no,
                        $this->getOrderRemark($item->remark),
                        $item->order_time,
                        $this->getOrderPayWay($item->pay_way),
                        $this->getOrderStatus($item->status),
                        $item->created_at
                    ];
                });
                $sheet->rows($rows);
            });
            $excel->sheet('单列体检', function ($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $sheet->row(1, ['ID', '下单用户', '手机号码', '送餐地址', '订单详情', '订单价格', '订单编号', '订单备注', '订单时间', '支付方式', '订单状态', '下单时间']);
                $rows = Order::hydrate($this->getData())->load('user')->where('status', '>', 1)->where('order_details_type', 'App\\Models\\Physical')->map(function ($item) {
                    return [
                        $item->id,
                        $item->user['name'],
                        $item->user['mobile'],
                        $item->user['address'],
                        $this->getOrderDetials($item),
                        $item->money,
                        $item->out_trade_no,
                        $this->getOrderRemark($item->remark),
                        $item->order_time,
                        $this->getOrderPayWay($item->pay_way),
                        $this->getOrderStatus($item->status),
                        $item->created_at
                    ];
                });
                $sheet->rows($rows);
            });
            $excel->sheet('套餐体检', function ($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $sheet->row(1, ['ID', '下单用户', '手机号码', '送餐地址', '订单详情', '订单价格', '订单编号', '订单备注', '订单时间', '支付方式', '订单状态', '下单时间']);
                $rows = Order::hydrate($this->getData())->load('user')->where('status', '>', 1)->where('order_details_type', 'App\\Models\\Package')->map(function ($item) {
                    return [
                        $item->id,
                        $item->user['name'],
                        $item->user['mobile'],
                        $item->user['address'],
                        $this->getOrderDetials($item),
                        $item->money,
                        $item->out_trade_no,
                        $this->getOrderRemark($item->remark),
                        $item->order_time,
                        $this->getOrderPayWay($item->pay_way),
                        $this->getOrderStatus($item->status),
                        $item->created_at
                    ];
                });
                $sheet->rows($rows);
            });
            $excel->sheet('预约挂号', function ($sheet) {
                // 这段逻辑是从表格数据中取出需要导出的字段
                $sheet->row(1, ['ID', '下单用户', '手机号码', '送餐地址', '订单详情', '订单价格', '订单编号', '订单备注', '订单时间', '支付方式', '订单状态', '下单时间']);
                $rows = Order::hydrate($this->getData())->load('user')->where('status', '>', 1)->where('order_details_type', 'App\\Models\\Scheduling')->map(function ($item) {
                    return [
                        $item->id,
                        $item->user['name'],
                        $item->user['mobile'],
                        $item->user['address'],
                        $this->getOrderDetials($item),
                        $item->money,
                        $item->out_trade_no,
                        $this->getOrderRemark($item->remark),
                        $item->order_time,
                        $this->getOrderPayWay($item->pay_way),
                        $this->getOrderStatus($item->status),
                        $item->created_at
                    ];
                });
                $sheet->rows($rows);
            });
        })->export('xls');
    }

    public function getOrderRemark($remark)
    {
        if (empty($remark)) {
            return '暂无备注';
        }
        switch ($remark) {
            case 'am':
                return '午餐';
                break;

            case 'pm':
                return '晚餐';
                break;
            default:
                return $remark;
                break;
        }
    }

    public function getOrderPayWay($pay_way)
    {
        $payways = [
            'wechat' => '微信支付',
            'card' => '一卡通支付',
            'ipad' => 'ipad支付',
        ];
        return $payways[$pay_way];
    }

    public function getOrderStatus($status)
    {
        $statuses = ['1' => '未支付', '2' => '已支付', '3' => '已兑换/已配送', '4' => '已完成', '5' => '已取消', '6' => '已退款'];
        return $statuses[$status];
    }
    public function getOrderDetials($order)
    {
        switch ($order->order_details_type) {
            case 'App\\Models\\Food':
                foreach ($order->order_details as $key => $value) {
                    $arr[] = "菜品：{$value['title']} 数量：{$value['num']} 单价：{$value['money']}";
                }
                return implode("<br/>", $arr);
                break;
            case 'App\\Models\\Physical':
                foreach ($order->order_details as $key => $value) {
                    $arr[] = "体检：{$value['title']} 数量：{$value['num']} 单价：{$value['money']}";
                }
                return implode("<br/>", $arr);
                break;
            case 'App\\Models\\Package':
                return "体检套餐：{$order->order_details['title']} <br/>数量：{$order->order_details['num']} <br/>价格（女）：{$order->order_details['women_money']} <br/>价格（男）：{$order->order_details['men_money']}";
                break;
            case 'App\\Models\\Scheduling':
                return "部门：{$order->order_details['doctor']['department']['name']} <br/>医生：{$order->order_details['doctor']['name']} <br/>地址：{$order->order_details['address']}";
                break;
        }
    }
}
