<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Dashboard untuk Admin (Role 1)
    public function indexAdmin()
    {
        $title = "Dashboard Admin";
        return view('dashboard.index', compact('title'));
    }

    // Dashboard untuk Kasir (Role 2) - FIX UNTUK ERROR INI
    public function indexKasir()
    {
        $title = "Dashboard Kasir";
        return view('dashboard.index', compact('title'));
    }

    // Dashboard untuk Manager / Pimpinan (Role 3)
    public function index()
    {
        $title = "Dashboard Pimpinan";
        return view('dashboard.index', compact('title'));
    }
}
