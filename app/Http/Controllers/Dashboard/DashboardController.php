<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(
    ) {
        $products = Product::all();
        return view('dashboard.index', ['products' => $products]);
    }
}
