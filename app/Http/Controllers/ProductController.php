<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\JenisObat;
use Illuminate\Support\Facades\Storage;

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

    public function indexbackend()
    {
        $index = Product::get();
        return view('backend.product.index', compact('index'));
    }

    public function data(Request $request)
    {
        $query = Product::select([
            'id_barang',
            'kd_barang',
            'nm_barang',
            'status',
            'sat_barang',
            'jenisobat',
            'hrgsat_barang',
            'hrgjual_barang'
        ]);

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                        <div class="dropdown-menu p-2">
                            <a href="' . route('backend.product.show', $row->id_barang) . '" class="btn btn-info btn-sm w-100 mb-1">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                            <a href="' . route('backend.product.edit', $row->id_barang) . '" class="btn btn-warning btn-sm w-100 mb-1">
                                <i class="far fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
        return view('backend.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('backend.product.update', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'status' => 'required|in:active,inactive',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Cek jika ada file gambar baru yang diupload
        if ($request->hasFile('gambar_produk')) {
            // Pastikan folder 'product' di disk 'public' tersedia
            if (!Storage::disk('public')->exists('product')) {
                Storage::disk('public')->makeDirectory('product');
            }

            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // Simpan gambar baru ke dalam folder 'product'
            $path = $request->file('gambar_produk')->store('product', 'public');
            $product->image = $path;
        }

        // Update data lainnya
        $product->status = $request->status;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {}

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
}
