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
    public function upload(Request $request): RedirectResponse
    {
        //dd(auth()->user());
        (new ProductsImport)->queue($request->file('productsFile'))->chain([
            new SuccessImportProductsNotificationJob(auth()->user())
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Tu importación se encuentra en progreso. A tu correo llegará una notificación cuando esté lista');
    }
}
