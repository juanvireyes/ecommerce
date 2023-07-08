<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductsDownloadController extends Controller
{
    public function __invoke(): BinaryFileResponse | RedirectResponse
    {
        $filePath = 'exports/products - ' . now()->format('d-m-Y') . '.xlsx';;
        $filePath = str_replace('\\', '/', $filePath);
        
        if (!Storage::exists($filePath)) {
            Log::error('Archivo no encontrado');
            return redirect()->route('products.index')->with('error', 'Archivo no encontrado');
        };

        Log::info('Pasamos por el controller de descarga');

        return response()->download(Storage::path($filePath));
    }
}
