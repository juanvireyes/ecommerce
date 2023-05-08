<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query();

        $search = $request->input;

        if ($search !== null) {
            $search = strtolower($search);
            $filtered_categories = $this->filterCategories($categories, $search);
        } else {
            $filtered_categories = $this->getCategories();
        };

        return view('clients.categories', compact('filtered_categories', 'search'));
    }

    public function getCategories(): array
    {
        $categories = Category::all()->sortBy('order');

        return  $categories->toArray();
    }

    public function filterCategories(Builder $categories, string $search): array
    {
        $filteredCategories = $categories->where('name', 'like', "%{$search}%")->get();

        return $filteredCategories->toArray();
    }

    public function getCategoryBySlug(string $slug): Category
    {
        return Category::where('slug', $slug)->first();
    }
}
