<?php

namespace App\Http\Resources;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Color;
use App\Models\Product\Product;
use App\Models\Product\Size;
use App\Models\Sales\SaleItem;
use App\Models\Suppliers\SupplierOrderItem;

class ProductResource
{
    public function getProducts($search = null)
    {
        $query = Product::query();

        if ($search) {
            $query->where('id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                ->orWhere('quantity', 'like', "%{$search}%")
                ->orWhereHas('color', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('size', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('brand', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        return $query->paginate(10);
    }

    public function getProduct(int $id)
    {
        $product = Product::with('brand', 'category', 'color', 'size')->find($id);
        return $product;
    }

    public function editProductQuantity(int $product_id): void
    {
        //Procura o produto mencionado nos pedidos do fornecedor (Entrada)
        $productEntrance = SupplierOrderItem::select('quantity')
            ->where('product_id', $product_id)
            ->sum('quantity');

        //Procuro os produtos mencionados em pedidos de clientes (Saída)
        $productExit = SaleItem::select('quantity')
            ->where('product_id', $product_id)
            ->sum('quantity');

        //Subtrai a quantidade de entrada pela quantidade de saída e atualiza o produto
        $productTotal = (int) $productEntrance - (int) $productExit;
        $product = Product::find($product_id);
        $product->update(['quantity' => $productTotal]);
    }

    public function saveProduct($data, $id = null)
    {
        if ($id) {
            $product = Product::find($id);
            $product->update($data);
        } else {
            $product = Product::create($data);
        }
        return $product;
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);

        //Verifica se o produto possui pedidos de fornecedores
        $supplierOrderItem = $product->supplierOrderItems()->count();
        if ($supplierOrderItem > 0) {
            return null;
        }

        //Verifica se o produto possui pedidos de clientes
        $saleItem = $product->saleItems()->count();
        if ($saleItem > 0) {
            return null;
        }

        $product->delete();
        return $product;
    }

    public function getBrands()
    {
        $brands = Brand::all()->sortBy('name');
        return $brands;
    }

    public function getCategories()
    {
        $categories = Category::all()->sortBy('name');
        return $categories;
    }

    public function getColors()
    {
        $colors = Color::all()->sortBy('name');
        return $colors;
    }

    public function getSizes()
    {
        $sizes = Size::all();
        return $sizes;
    }
}
