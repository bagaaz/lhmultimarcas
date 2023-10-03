<?php

namespace App\Http\Resources;

use App\Models\Product\Product;
use App\Models\Sales\Sale;
use App\Models\Sales\SaleIntallment;
use App\Models\Sales\SaleItem;

class SaleResource
{
    public function getSales($search = null)
    {
        $query = Sale::with(['client', 'paymentMethod'])
            ->select('sales.*')
            ->selectRaw('(SELECT COUNT(*) FROM sales_items WHERE sales_items.sale_id = sales.id) as products_count')
            ->selectRaw('(SELECT SUM(quantity) FROM sales_items WHERE sales_items.sale_id = sales.id) as products_total_count')
            ->selectRaw('(SELECT SUM(quantity * unity_price) FROM sales_items WHERE sales_items.sale_id = sales.id) as order_total_value')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where('id', 'like', "%{$search}%")
                ->orWhereHas('client', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });

        }

        return $query->paginate(10);
    }

    public function getSale(int $sale_id)
    {
        $sale = Sale::with(['client', 'paymentMethod'])->findOrFail($sale_id);
        return $sale;
    }

    public function storeSale(array $data)
    {
        $sale = new Sale();
        $sale->client_id = $data['client_id'];
        $sale->payment_method_id = $data['payment_method_id'];
        $sale->discount = 0.00;
        $sale->save();

        return $sale;
    }

    public function updateSale(int $sale_id, array $data)
    {
        $sale = Sale::findOrFail($sale_id);
        $sale->client_id = $data['client_id'];
        $sale->payment_method_id = $data['payment_method_id'];
        $sale->discount = $data['discount'];
        $sale->save();

        return $sale;
    }

    public function deleteSale(int $sale_id)
    {
        $saleItems = SaleItem::where('sale_id', $sale_id)->get();
        foreach ($saleItems as $saleItem) {
            $saleItem->delete();
        }
        $sale = Sale::findOrFail($sale_id);
        $sale->delete();

        return $sale;
    }

    public function getSaleItems(int $sale_id)
    {
        $saleItems = SaleItem::with('product')
            ->selectRaw('id, sale_id, product_id, quantity, unity_price, quantity * unity_price AS order_item_total, SUM(quantity * unity_price) OVER () AS order_total')
            ->where('sale_id', $sale_id)
            ->orderBy('created_at', 'desc');

        return $saleItems->get();
    }

    public function getProducts()
    {
        $products = Product::with(['color', 'size', 'brand'])->orderBy('name', 'asc');
        return $products->get();
    }
}
