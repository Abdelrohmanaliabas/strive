<?php

namespace App\Http\Controllers;

use App\Models\Analytic;
use App\Http\Requests\StoreAnalyticRequest;
use App\Http\Requests\UpdateAnalyticRequest;

class AnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $analytics = Analytic::with('jobPost')->orderBy('last_viewed_at', 'desc')->paginate(10);
        return view('admin.analytics.index', compact('analytics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnalyticRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Analytic $analytic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analytic $analytic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnalyticRequest $request, Analytic $analytic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analytic $analytic)
    {
        //
    }
}
