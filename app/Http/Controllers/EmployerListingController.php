<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployerListingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:candidate,employer,admin']);
    }

    public function index()
    {
        $employers = User::where('role', 'employer')->get();
        return view('pages.employers', compact('employers'));
    }
}
