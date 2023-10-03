<?php

namespace App\Models\Suppliers;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierOrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers_orders_items';
    protected $fillable = [
        'supplier_order_id',
        'product_id',
        'quantity',
        'unity_price'
    ];

    public function supplierOrder()
    {
        return $this->belongsTo(SupplierOrder::class, 'supplier_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
