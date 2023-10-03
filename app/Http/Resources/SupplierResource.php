<?php

namespace App\Http\Resources;

use App\Models\Suppliers\Supplier;

class SupplierResource
{
    public function getSuppliers(string $search = null)
    {
        $suppliers = Supplier::orderBy('name', 'asc');
        if ($search) {
            $suppliers->where('name', 'like', "%{$search}%")
                ->orWhere('cnpj', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('site', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
        }

        return $suppliers->paginate(10);
    }

    public function getSupplier(int $id)
    {
        return Supplier::find($id);
    }

    public function saveSupplier(array $data, int $id = null)
    {
        if ($id) {
            $supplier = Supplier::find($id);
            $supplier->update($data);
        } else {
            $existingSupplier = Supplier::where('cnpj', $data['cnpj'])->first();
            if ($existingSupplier) {
                return null;
            }
            $supplier = Supplier::create($data);
        }

        return $supplier;
    }

    public function deleteSupplier(int $id)
    {
        $supplier = Supplier::find($id);

        if ($supplier->supplierOrders->count() > 0) {
            return null;
        }

        $supplier->delete();
        return $supplier;
    }
}
