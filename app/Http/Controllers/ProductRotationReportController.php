<?php

namespace App\Http\Controllers;

use App\Exports\ProductRotationReportExport;
use App\Jobs\ProductRotationRepNotificationJob;
use App\Models\Product;
use App\Models\ProductRotationReport;
use App\Notifications\ReportReadyNotification;
use App\Repositories\ProductRepository;
use App\Repositories\ProductRotationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductRotationReportController extends Controller
{
    public function __construct(
        public ProductRotationRepository $registerData,
        public ProductRepository $productData,
    )
    {}

    public function index(Request $request): View
    {
        $filter = $request->input('sortProducts');
        $column = 'product_id';
        $orderBy = 'asc';

        if ($filter == 'mostSelled') {
            $column = 'sold_units';
            $orderBy = 'desc';
        } elseif ($filter == 'lessSelled') {
            $column = 'sold_units';
        }

        $registers = $this->registerData->getAllRegisters($column, $orderBy);

        return view('reports.partials.products-rotation', compact('registers', 'request'));
    }

    public function exportProductsReport(Request $request): RedirectResponse
    {
        $filter = $request->input('sortProducts');
        $column = 'product_id';
        $order = 'asc';

        if ($filter == 'mostSelled') {
            $column = 'sold_units';
            $order = 'desc';
        } elseif ($filter == 'lessSelled') {
            $column = 'sold_units';
        }
        //dd($request->all());
        $fileName = 'Rotación Productos - ' . now()->format('d-m-Y') . '.xlsx';
        (new ProductRotationReportExport($column, $order))->queue('exports/' . $fileName)->chain([
            new ProductRotationRepNotificationJob(request()->user())
        ]);

        return redirect()
            ->route('reports.products')
            ->with('success',
                'La exportación del reporte ha iniciado correctamente.
                Recibirás una notificación en tu correo una vez finalice'
            );
    }
}
