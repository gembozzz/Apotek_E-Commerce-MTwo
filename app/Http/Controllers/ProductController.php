<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\JenisObat;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisobat = JenisObat::get();
        $produk = Product::paginate(8);
        return view('frontend.v_produk.index', compact('produk', 'jenisobat'));
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function detail($id)
    {
        $jenisobat = JenisObat::get();
        $produks = Product::with('jenisObat')->findOrFail($id);
        $kategori = JenisObat::orderBy('jenisobat', 'desc')->get();
        return view('frontend.v_produk.detail', [
            'judul' => 'Detail Produk',
            'kategori' => $kategori,
            'produks' => $produks,
            'jenisobat' => $jenisobat
        ]);
    }

    public function produkKategori($id)
    {
        // Ambil semua kategori untuk sidebar/menu
        $jenisobat = JenisObat::all();

        // Cari kategori berdasarkan id (karena di URL yang dikirim tetap idjenis)
        $selectedKategori = JenisObat::where('idjenis', $id)->firstOrFail();

        // Ambil produk berdasarkan label 'jenisobat' (bukan id)
        $produk = Product::where('jenisobat', $selectedKategori->jenisobat)->paginate(8);

        return view('frontend.v_produk.produkkategori', [
            'judul' => 'Kategori: ' . $selectedKategori->jenisobat_label,
            'kategori' => $jenisobat,
            'produk' => $produk,
            'jenisobat' => $jenisobat
        ]);
    }
}
