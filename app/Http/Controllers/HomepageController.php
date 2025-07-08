<?php

namespace App\Http\Controllers;

use App\Models\homepage;
use Illuminate\Http\Request;
use App\Models\JenisObat;
use App\Models\Product;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $jenisobat = JenisObat::get();
        $latestProject = Product::where('jenisobat','OTC1')->paginate(4);
        $databarang = Product::paginate(6);
        return view('frontend.dashboard.index', compact('databarang','latestProject', 'jenisobat'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(homepage $homepage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(homepage $homepage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, homepage $homepage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(homepage $homepage)
    {
        //
    }
}
