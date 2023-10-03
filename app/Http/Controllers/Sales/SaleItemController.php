<?php

namespace App\Http\Controllers\Sales;

use App\Helpers\Helper;
use App\Helpers\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleItemResource;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    protected $saleItemResource;

    public function __construct(SaleItemResource $saleItemResource)
    {
        $this->saleItemResource = $saleItemResource;
    }

    public function create(Request $request, int $sale_id)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'unity_price' => 'required',
        ]);
        $data = $request->only(['product_id', 'quantity', 'unity_price']);
        $data['unity_price'] = Helper::clearMaskMoney($data['unity_price']);
        $saleItem = $this->saleItemResource->createSaleItem($sale_id, $data);

        Message::success('Item adicionado com sucesso!');
        return redirect()->route('sales.edit', ['id' => $sale_id]);
    }

    public function destroy(int $sale_id, int $sale_item_id)
    {
        $this->saleItemResource->deleteSaleItem($sale_item_id);
        Message::success('Item removido com sucesso!');
        return response()->json(['message' => 'Item removido com sucesso!']);
    }
}
