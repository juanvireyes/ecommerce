<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductRotationRepDownloadController extends Controller
{
    public function __invoke(Request $request): BinaryFileResponse|RedirectResponse
    {
        $filePath = 'exports/Rotación Productos - ' . now()->format('d-m-Y') . '.xlsx';
        $filePath = str_replace('\\', '/', $filePath);

        if (!Storage::exists($filePath)) {
            Log::error('Archivo no encontrado');
            return redirect()->route('products.index')->with('error', 'Archivo no encontrado');
        }

        return response()->download(Storage::path($filePath));
    }
}
