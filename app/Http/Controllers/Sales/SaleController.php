<?php

namespace App\Http\Controllers\Sales;

use App\Helpers\Helper;
use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;
use App\Models\Client;
use App\Models\Product\Product;
use App\Models\Sales\PaymentMethod;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleResource;

    public function __construct(SaleResource $saleResource)
    {
        $this->saleResource = $saleResource;
    }

    public function index($search = null)
    {
        $sales = $this->saleResource->getSales($search);
        $products = $this->saleResource->getProducts();

        return view('pages.sales.table', compact('sales'));
    }

    public function create()
    {
        $products = $this->saleResource->getProducts();
        return view('pages.sales.form', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'payment_method_id' => 'required'
        ]);
        $data = $request->only(['client_id', 'payment_method_id']);

        $sale = $this->saleResource->storeSale($data);
        return redirect()->route('sales.edit', ['id' => $sale->id]);
    }

    public function edit(int $id)
    {
        $sale = $this->saleResource->getSale($id);
        $sale->discount = Helper::maskMoney($sale->discount);
        $saleItems = $this->saleResource->getSaleItems($id);
        $products = $this->saleResource->getProducts();
        return view('pages.sales.form', ['sale' => $sale, 'products' => $products, 'saleItems' => $saleItems]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'client_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        $data = $request->only(['client_id', 'payment_method_id', 'discount']);
        $data['discount'] = Helper::clearMaskMoney($data['discount']);
        $sale = $this->saleResource->updateSale($id, $data);

        Message::success('Venda atualizada com sucesso!');

        return redirect()->route('sales.index');
    }

    public function destroy(int $id)
    {
        $this->saleResource->deleteSale($id);
        Message::success('Venda removida com sucesso!');
        return redirect()->route('sales.index');
    }

    //Select2
    public function getClientOptions()
    {
        $clients = Client::select('id', 'name', 'cpf')->get();

        $clientsFormatted = $clients->mapWithKeys(function ($client) {
            return [$client['id'] => $client['name'] . ' - CPF (' . Helper::maskCPF($client['cpf']) . ')'];
        })->toArray();

        return response()->json($clientsFormatted);
    }

    public function getPaymentMethodOptions()
    {
        $paymentMethods = PaymentMethod::select('id', 'name', 'tax')->get();
        $paymentMethodsFormatted = $paymentMethods->mapWithKeys(function ($paymentMethod) {
            return [$paymentMethod['id'] => $paymentMethod['name'] . ' - Taxa ' . $paymentMethod['tax'] . ' %'];
        })->toArray();

        return response()->json($paymentMethodsFormatted);
    }

    public function getProductsOptions()
    {
        $products = Product::with(['color', 'size', 'brand'])->orderBy('name', 'asc')->get();
        $productsFormatted = $products->mapWithKeys(function ($product) {
            return [$product['id'] => $product['name'] . ' | ' . $product['color']['name'] . ' | ' . $product['size']['name'] . ' | ' . $product['brand']['name']];
        })->toArray();

        return response()->json($productsFormatted);
    }
}
