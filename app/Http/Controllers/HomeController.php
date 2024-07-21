<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan') {
            $masalahbelum = Problem::where('status', 'belum ditangani')->count();
            $masalahproses = Problem::where('status', 'proses penanganan')->count();
            $masalahselesai = Problem::where('status', 'selesai ditangani')->count();
            return view('dashboard.index', compact('masalahbelum', 'masalahproses', 'masalahselesai'));
        } else {
            return view('dashboard.index');
        }
    }
}
