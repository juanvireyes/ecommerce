<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportsIndexController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }
}
