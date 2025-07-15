<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Article;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $customers = User::all();
        $articles = Article::all();
        return view('backend.dashboard.index', compact('products', 'customers', 'articles'));
    }
}
