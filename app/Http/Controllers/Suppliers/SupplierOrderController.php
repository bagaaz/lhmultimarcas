<?php

namespace App\Http\Controllers\Suppliers;

use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierOrderResource;
use Illuminate\Http\Request;

class SupplierOrderController extends Controller
{
    protected $supplierOrderResource;

    public function __construct(SupplierOrderResource $resource)
    {
        $this->supplierOrderResource = $resource;
    }

    public function index(Request $request, int $supplier_id)
    {
        $search = $request->get('search');
        $supplierOrders = $this->supplierOrderResource->getSupplierOrders($supplier_id, $search);
        $erro = false;
        foreach ($supplierOrders as $supplierOrder) {
            if ($supplierOrder->products_count === 0) {
                $erro = true;
                $supplierOrder->delete();
            }
        }
        if ($erro) {
            Message::error('Foram encontrados pedidos sem itens, os mesmos foram deletados!');
        }
        return view('pages.suppliers.orders.table', compact('supplierOrders', 'supplier_id'));
    }

    public function create(int $supplier_id)
    {
        $products = $this->supplierOrderResource->getProducts();
        return view('pages.suppliers.orders.form', compact('supplier_id', 'products'));
    }

    public function edit(int $supplier_id, int $supplier_order_id)
    {
        $supplierOrderItems = $this->supplierOrderResource->getSupplierOrderItems($supplier_order_id);
        $products = $this->supplierOrderResource->getProducts();
        return view('pages.suppliers.orders.form', compact('supplier_id', 'supplier_order_id', 'supplierOrderItems', 'products'));
    }

    public function update(Request $request, int $supplier_id, int $supplier_order_id)
    {
        $supplierOrderItems = $this->supplierOrderResource->getSupplierOrderItems($supplier_order_id);
        if ($supplierOrderItems->count() === 0) {
            $this->supplierOrderResource->deleteSupplierOrder($supplier_order_id);
            Message::error('Não é possível atualizar um pedido sem itens, o mesmo foi deletado!');
            return redirect()->route('suppliers.orders.index', ['supplier_id' => $supplier_id]);
        }
        Message::success('Pedido atualizado com sucesso!');
        return redirect()->route('suppliers.orders.index', ['supplier_id' => $supplier_id]);
    }

    public function destroy(int $supplier_id, int $supplier_order_id)
    {
        $this->supplierOrderResource->deleteSupplierOrder($supplier_order_id);
        Message::success('Pedido removido com sucesso!');
        return redirect()->route('suppliers.orders.index', ['supplier_id' => $supplier_id]);
    }
}
