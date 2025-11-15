<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;

class CategoryListingController extends Controller
{

    public function index()
    {
        $categories = JobCategory::paginate(12);
        return view('pages.categories', compact('categories'));
    }
}
