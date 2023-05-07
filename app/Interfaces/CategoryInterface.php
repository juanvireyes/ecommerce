<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CategoryInterface {

    public function getAllCategories();

    public function getCategoryBySlug(?string $slug);
}
