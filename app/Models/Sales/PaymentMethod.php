<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_methods';
    protected $fillable = [
        'name',
        'tax'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class, 'payment_method_id');
    }
}
