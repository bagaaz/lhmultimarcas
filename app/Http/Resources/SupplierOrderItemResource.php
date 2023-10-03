<?php

namespace App\Http\Resources;

use App\Models\Suppliers\SupplierOrder;
use App\Models\Suppliers\SupplierOrderItem;

class SupplierOrderItemResource
{
    public function getSupplierOrderItems(int $supplier_order_id)
    {
        $query = SupplierOrderItem::with('product')->where('supplier_order_id', $supplier_order_id)
            ->orderBy('created_at', 'desc');

        return $query->paginate(10);
    }

    public function createSupplierOrder(int $supplier_id)
    {
        $supplierOrder = SupplierOrder::create([
            'supplier_id' => $supplier_id
        ]);

        return $supplierOrder;
    }

    public function saveSupplierOrderItem(array $data)
    {
        $supplierOrderItem = SupplierOrderItem::create($data);
        return $supplierOrderItem;
    }

    public function deleteSupplierOrderItem(int $id)
    {
        $supplierOrderItem = SupplierOrderItem::find($id);
        $supplierOrderItem->delete();
    }
}
