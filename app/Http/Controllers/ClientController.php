<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private CategoryRepository $categoriesRepository;

    public function __construct(CategoryRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function index(Request $request): View
    {
        $categories = $this->categoriesRepository->getAllCategories();
        $search = $request->input('filter');

        if ($search) {
            $search = strtolower($search);
            $filtered_categories = $this->filterCategories($search);
        }

        $filtered_categories = $categories;

        return view('clients.categories', compact('filtered_categories', 'search'));
    }

    public function filterCategories(string $search) : array
    {
        $filteredCategories = $this->categoriesRepository->getCategoryByName($search)->get();

        return $filteredCategories ? [$filteredCategories] : [];
    }
}
