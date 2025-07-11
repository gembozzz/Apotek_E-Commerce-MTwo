<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        return view('backend.category.index', compact('category'));
    }

    public function data()
    {
        $categories = Category::select(
            'id',
            'name'
        );
        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $btn = '<div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Action</button>
                        <div class="dropdown-menu p-2">
                        <a href="' . route('category.edit', $row->id) . '" class="btn btn-warning btn-sm w-100 mb-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="' . route('category.destroy', $row->id) . '" class="btn btn-danger btn-sm w-100 mb-1">
                                <i class="fas fa-trash"></i> Hapus
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
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('backend.category.update', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }
}
