<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use Illuminate\Http\Request;

class CategoryListingController extends Controller
{
    
    public function index()
    {
        $categories = JobCategory::all();
        return view('pages.categories', compact('categories'));
    }
}
