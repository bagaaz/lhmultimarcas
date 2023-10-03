<?php

namespace App\Http\Controllers\Suppliers;

use App\Helpers\Helper;
use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierOrderItemResource;
use Illuminate\Http\Request;

class SupplierOrderItemController extends Controller
{
    protected $supplierOrderItemResource;

    public function __construct(SupplierOrderItemResource $resource)
    {
        $this->supplierOrderItemResource = $resource;
    }

    public function create(Request $request, int $supplier_id)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'unity_price' => 'required',
        ]);
        $data = $request->only(['supplier_order_id', 'product_id', 'quantity', 'unity_price']);
        $data['unity_price'] = Helper::clearMaskMoney($data['unity_price']);

        if (!isset($data['supplier_order_id'])) {
            $supplierOrder = $this->supplierOrderItemResource->createSupplierOrder($supplier_id);
            $data['supplier_order_id'] = $supplierOrder->id;
        }
        $supplierOrderItem = $this->supplierOrderItemResource->saveSupplierOrderItem($data);

        Message::success('Item adicionado com sucesso!');
        return redirect()->route('suppliers.orders.edit', ['supplier_id' => $supplier_id, 'order' => $supplierOrderItem->supplier_order_id]);
    }

    public function destroy(int $supplier_id, int $supplier_order_id, int $supplier_order_item_id)
    {
        $this->supplierOrderItemResource->deleteSupplierOrderItem($supplier_order_item_id);
        Message::success('Item removido com sucesso!');
        return response()->json(['message' => 'Item removido com sucesso!']);
    }
}
