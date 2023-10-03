<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

class SaleInstallmentController extends Controller
{
    public function index()
    {
        return view('pages.sales.installments.form');
    }
}
