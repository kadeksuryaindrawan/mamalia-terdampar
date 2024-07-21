<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan'){
            $masalahbelum = Problem::where('status', 'belum ditangani')->count();
            $masalahproses = Problem::where('status', 'proses penanganan')->count();
            $masalahselesai = Problem::where('status', 'selesai ditangani')->count();
            return view('dashboard.index',compact('masalahbelum','masalahproses','masalahselesai'));
        }else{
            return view('dashboard.index');
        }

    }

    public function donation()
    {
        return view('dashboard.donation');
    }

    public function ubahPassword($id)
    {
        $user = User::find($id);
        return view('dashboard.ubahpassword', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        try {
            User::where('id', $id)->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->route('dashboard')->with('success', 'Berhasil ubah password!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
