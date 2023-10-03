<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use App\Models\Sales\Sale;
use App\Models\Suppliers\SupplierOrder;
use Illuminate\Support\Facades\DB;

class DashboardResource
{
    public function getData(string $filter)
    {
        $period = $this->getPeriod($filter);

        $stockValue = $this->getStockValue($period);
        $salesQuantity = $this->getSalesQuantity($period);
        $salesValue = $this->getSalesValue($period);
        $salesLiquidValue = $this->getLiquidSalesValue($period);

        return [
            'stock_value' => Helper::maskMoney($stockValue),
            'sales_quantity' => $salesQuantity,
            'sales_value' => Helper::maskMoney($salesValue),
            'sales_liquid_value' => Helper::maskMoney($salesLiquidValue)
        ];
    }

    private function getStockValue(string $period) {
        $total = SupplierOrder::with(['items'])
            ->whereRaw('created_at >= ?', [$period])
            ->get()
            ->sum(function($order) {
                return $order->items->sum(function($item) {
                    return $item->quantity * $item->unity_price;
                });
            });

        return $total;
    }

    public function getSalesQuantity(string $period) {
        $total = Sale::where(DB::raw('created_at'), '>=', $period)
            ->count();

        return $total;
    }

    public function getSalesValue(string $period) {
        $query = "
            SELECT SUM(items.quantity * items.unity_price) AS total
            FROM sales
            JOIN sales_items AS items ON sales.id = items.sale_id
            WHERE sales.created_at >= ?
        ";
        $total = DB::select($query, [$period])[0]->total;

        return $total;
    }

    public function getLiquidSalesValue(string $period) {
        $query = "
        SELECT SUM(
            (items.quantity * items.unity_price) -
            ((items.quantity * items.unity_price) * payment_methods.tax / 100) -
            sales.discount
        ) AS total
        FROM sales
        JOIN sales_items AS items ON sales.id = items.sale_id
        JOIN payment_methods ON sales.payment_method_id = payment_methods.id
        WHERE sales.created_at >= ?
    ";
        $total = DB::select($query, [$period])[0]->total;

        return $total;
    }


    private function getPeriod(string $filter) {
        if ($filter == '24h') {
            $date = date('Y-m-d H:i:s', strtotime('-24 hours'));
        } else if ($filter == '7d') {
            $date = date('Y-m-d H:i:s', strtotime('-7 days'));
        } else if ($filter == '1m') {
            $date = date('Y-m-d H:i:s', strtotime('-1 month'));
        } else if ($filter == '1y') {
            $date = date('Y-m-d H:i:s', strtotime('-1 year'));
        } else {
            $date = date('Y-m-d H:i:s', strtotime('-100 years'));
        }
        return $date;
    }
}
