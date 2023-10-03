<?php

namespace App\Http\Resources;

use App\Models\Product\Product;
use App\Models\Suppliers\SupplierOrder;
use App\Models\Suppliers\SupplierOrderItem;

class SupplierOrderResource
{
    public function getSupplierOrders(int $supplier_id, string $search = null)
    {
        $query = SupplierOrder::with('supplier')
            ->select('suppliers_orders.*')  // Seleciona todas as colunas da tabela principal
            ->selectRaw('(SELECT COUNT(*) FROM suppliers_orders_items WHERE suppliers_orders_items.supplier_order_id = suppliers_orders.id AND suppliers_orders_items.deleted_at IS NULL) as products_count')
            ->selectRaw('(SELECT SUM(quantity) FROM suppliers_orders_items WHERE suppliers_orders_items.supplier_order_id = suppliers_orders.id AND suppliers_orders_items.deleted_at IS NULL) as products_total_count')
            ->selectRaw('(SELECT SUM(quantity * unity_price) FROM suppliers_orders_items WHERE suppliers_orders_items.supplier_order_id = suppliers_orders.id AND suppliers_orders_items.deleted_at IS NULL) as order_total_value')
            ->where('supplier_id', $supplier_id)
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where('id', 'like', "%{$search}%")
                ->orWhereHas('supplier', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        }

        return $query->paginate(10);
    }

    public function getSupplierOrderItems(int $supplier_order_id)
    {
        $supplierOrderItems = SupplierOrderItem::with('product')
            ->selectRaw('id, supplier_order_id, product_id, quantity, unity_price, quantity * unity_price AS order_item_total, SUM(quantity * unity_price) OVER () AS order_total')
            ->where('supplier_order_id', $supplier_order_id)
            ->orderBy('created_at', 'desc');

        return $supplierOrderItems->get();
    }


    public function getProducts()
    {
        $products = Product::with(['color', 'size', 'brand'])->orderBy('name', 'asc');
        return $products->get();
    }

    public function deleteSupplierOrder(int $supplier_order_id): void
    {
        $supplierOrder = SupplierOrder::find($supplier_order_id);
        $supplierOrder->delete();
    }
}
