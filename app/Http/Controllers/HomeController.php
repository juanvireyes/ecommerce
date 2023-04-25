<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query();
        
        $filter = $request->filter;

        if ($filter != null) {
            $filter = strtolower($filter);
            $filtered_categories = $this->filter_categories($categories, $filter);
        } else {
            $filtered_categories = $this->get_categories();
        };
        
        return view('home',  compact('filtered_categories'), compact('filter'));
    }

    private function get_categories(): array
    {
        $categories = Category::all()->sortBy('order');

        return $categories->toArray();
    }

    private function filter_categories(Builder $categories, string $filter): array
    {
        $filtered_categories = $categories->where('name', 'LIKE', '%' . $filter . '%')->get();

        return $filtered_categories->toArray();
    }

    public function user_info(): View
    {
        return view('user-info');
    }
}
