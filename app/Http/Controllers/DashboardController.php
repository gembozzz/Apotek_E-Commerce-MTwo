<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function backendIndex()
    {
        return view('backend.dashboard.index');
    }

    public function frontendIndex()
    {
        return view('frontend.dashboard.index');
    }
}
