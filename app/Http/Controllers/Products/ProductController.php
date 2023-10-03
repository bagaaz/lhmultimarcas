<?php

namespace App\Http\Controllers\Products;

use App\Helpers\Message;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    protected $productResource;

    public function __construct(ProductResource $resource)
    {
        $this->productResource = new $resource;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = $this->productResource->getProducts($search);
        foreach ($products as $product) {
            $this->productResource->editProductQuantity($product->id);
        }
        return view('pages.products.table', compact('products'));
    }

    public function create()
    {
        $relations = [
            'brands' => $this->productResource->getBrands(),
            'categories' => $this->productResource->getCategories(),
            'colors' => $this->productResource->getColors(),
            'sizes' => $this->productResource->getSizes(),
        ];
        return view('pages.products.form', compact('relations'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'description', 'quantity', 'brand_id', 'category_id', 'color_id', 'size_id',]);
        $product = $this->productResource->saveProduct($data);
        Message::success('Produto cadastrado com sucesso');
        return redirect()->route('products.index');
    }

    public function edit(int $id)
    {
        $relations = [
            'brands' => $this->productResource->getBrands(),
            'categories' => $this->productResource->getCategories(),
            'colors' => $this->productResource->getColors(),
            'sizes' => $this->productResource->getSizes(),
        ];
        $product = $this->productResource->getProduct($id);
        return view('pages.products.form', compact('product', 'relations'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'description', 'quantity', 'brand_id', 'category_id', 'color_id', 'size_id',]);
        $product = $this->productResource->saveProduct($data, $id);
        Message::success('Produto atualizado com sucesso');
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = $this->productResource->deleteProduct($id);

        if ($product === null) {
            Message::error('Produto não pode ser excluído pois está vinculado a outros registros');
            return redirect()->route('products.index');
        }

        Message::success('Produto excluído com sucesso');
        return redirect()->route('products.index');
    }

    public function getProducts($search = null)
    {
        $query = Product::query();

        if ($search) {
            $query->where('id', 'like', "%{$search}%")
                ->orWhere('name', 'like', "%{$search}%")
                // Adicione outras colunas que você quer pesquisar
                ->orWhere('quantity', 'like', "%{$search}%");
        }

        return $query->paginate();
    }
}
