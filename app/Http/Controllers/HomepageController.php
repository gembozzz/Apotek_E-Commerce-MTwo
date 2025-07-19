<?php

namespace App\Http\Controllers;

use App\Models\homepage;
use Illuminate\Http\Request;
use App\Models\JenisObat;
use App\Models\Product;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
        $jenisobat = JenisObat::get();
        $kategori = Category::orderBy('name', 'desc')->get();
        $produkTerbaru = Product::where('status', 'active')->take(4)->get();
        $databarang = Product::where('status', 'active')->paginate(5);
        $diskonbarang = Product::where('diskon', '>', 0)->paginate(5);
        
        $articles = Article::where('status', 'published')->orderBy('created_at', 'desc')->paginate(3);
        return view('frontend.dashboard.index', compact('databarang', 'produkTerbaru', 'jenisobat', 'kategori', 'articles', 'diskonbarang'));
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
