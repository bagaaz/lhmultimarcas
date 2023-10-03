<?php

namespace App\Http\Resources;

use App\Models\Sales\SaleItem;

class SaleItemResource
{
    public function createSaleItem(int $sale_id, array $data)
    {
        $saleItem = new SaleItem();
        $saleItem->sale_id = $sale_id;
        $saleItem->product_id = $data['product_id'];
        $saleItem->quantity = $data['quantity'];
        $saleItem->unity_price = $data['unity_price'];
        $saleItem->save();

        return $saleItem;
    }

    public function deleteSaleItem(int $sale_item_id)
    {
        $saleItem = SaleItem::find($sale_item_id);
        $saleItem->delete();
    }
}
