<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRotationRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class TestingController extends Controller
{
    public function index(Request $request, ProductRotationRepository $data)
    {
        //
    }
}
