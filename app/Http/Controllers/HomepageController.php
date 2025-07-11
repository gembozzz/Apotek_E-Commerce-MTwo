<?php

namespace App\Http\Controllers;

use App\Models\homepage;
use Illuminate\Http\Request;
use App\Models\JenisObat;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $produkpalingbanyakterjual = Product::select('barang.*', DB::raw('SUM(trkasir_detail.qty_dtrkasir) as total_terjual'))
            ->join('trkasir_detail', 'trkasir_detail.id_barang', '=', 'barang.id_barang')
            ->groupBy('barang.id_barang')
            ->orderByDesc('total_terjual')
            ->limit(6)
            ->get();
        $jenisobat = JenisObat::get();
        $kategori = Category::orderBy('name', 'desc')->get();
        $produkTerbaru = Product::where('status', 'active')->take(4)->get();
        $databarang = Product::where('status', 'active')->paginate(6);
        return view('frontend.dashboard.index', compact('databarang', 'produkTerbaru', 'jenisobat', 'produkpalingbanyakterjual', 'kategori'));
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
