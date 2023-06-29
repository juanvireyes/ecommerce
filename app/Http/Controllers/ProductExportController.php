<?php

namespace App\Http\Controllers;

use App\Jobs\ProductsExportJob;
use Illuminate\Http\Request;

class ProductExportController extends Controller
{
    public function __invoke(Request $request)
    {
        ProductsExportJob::dispatch();
        return response()->json(['data' => 'products.csv', 200]);
    }
}
