<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleIntallment extends Model
{
    use HasFactory;

    protected $table = 'sales_installments';
    protected $fillable = [
        'sale_id',
        'value',
        'due_date',
        'paid'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
