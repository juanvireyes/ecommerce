<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsFileRequest;
use App\Imports\ProductsImport;
use App\Jobs\SuccessImportProductsNotificationJob;
use App\Notifications\ProductsImportNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

;

class ProductsImportController extends Controller
{
    public function upload(ProductsFileRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        (new ProductsImport)->queue($validated['productsFile'])->chain([
            new SuccessImportProductsNotificationJob(request()->user())
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Tu importación se encuentra en progreso. A tu correo llegará una notificación cuando esté lista');
    }
}
