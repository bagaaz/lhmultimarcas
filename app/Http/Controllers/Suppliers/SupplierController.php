<?php

namespace App\Http\Controllers\Suppliers;

use App\Helpers\Helper;
use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierResource;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierResource;

    public function __construct(SupplierResource $resource)
    {
        $this->supplierResource = $resource;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $suppliers = $this->supplierResource->getSuppliers($search);
        return view('pages.suppliers.table', compact('suppliers'));
    }

    public function create()
    {
        return view('pages.suppliers.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->only(['id', 'name', 'cnpj', 'email', 'phone', 'site', 'address']);
        $data['cnpj'] = Helper::clearMaskCNPJ($data['cnpj']);
        $data['phone'] = Helper::clearMaskPhone($data['phone']);
        $supplier = $this->supplierResource->saveSupplier($data);
        if ($supplier === null) {
            Message::error('Fornecedor já cadastrado com esse CNPJ');
            return redirect()->route('suppliers.index');
        }
        Message::success('Fornecedor cadastrado com sucesso');
        return redirect()->route('suppliers.index');
    }

    public function edit(int $id)
    {
        $supplier = $this->supplierResource->getSupplier($id);
        return view('pages.suppliers.form', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $data = $request->only(['id', 'name', 'cnpj', 'email', 'phone', 'site', 'address']);
        $data['cnpj'] = Helper::clearMaskCNPJ($data['cnpj']);
        $data['phone'] = Helper::clearMaskPhone($data['phone']);
        $supplier = $this->supplierResource->saveSupplier($data, $id);
        Message::success('Fornecedor atualizado com sucesso');
        return redirect()->route('suppliers.index');
    }

    public function destroy(int $id)
    {
        $supplier = $this->supplierResource->deleteSupplier($id);

        if ($supplier === null) {
            Message::error('Não foi possível excluir o fornecedor pois existem pedidos vinculados a ele');
            return redirect()->route('suppliers.index');
        }

        Message::success('Fornecedor excluído com sucesso');
        return redirect()->route('suppliers.index');
    }
}
