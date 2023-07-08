<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Jobs\ProductsDownloadNotificationJob;
use Illuminate\Http\RedirectResponse;

class ProductExportController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $fileName = 'products - ' . now()->format('d-m-Y') . '.xlsx';
        (new ProductsExport)->queue('exports/' . $fileName)->chain([
            new ProductsDownloadNotificationJob(request()->user()),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Tu exportación inició correctamente. 
            En tu correo encontrarás un enlace de descarga cuando el archivo esté listo.');
    }
}
