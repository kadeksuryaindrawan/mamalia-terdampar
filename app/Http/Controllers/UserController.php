<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at','desc')->get();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'no_telp' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.create')->withErrors($validator)->withInput();
        }
        try {
            User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect()->route('user.index')->with('success', 'Berhasil tambah user!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            if ($user->email == $request->email) {
                $validator = Validator::make($request->all(), [
                    'nama' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255'],
                    'no_telp' => ['required', 'numeric'],
                    'role' => ['required']
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'nama' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'max:255', 'unique:users'],
                    'no_telp' => ['required', 'numeric'],
                    'role' => ['required']
                ]);
            }
            if ($validator->fails()) {
                return redirect()->route('user.edit', ['user' => $user->id])->withErrors($validator)->withInput();
            }
            if ($request->password == NULL) {
                $user->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_telp' => $request->no_telp,
                    'role' => $request->role
                ]);
            } else {
                Validator::make($request->all(), [
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                    'role' => ['required']
                ]);
                $user->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                    'no_telp' => $request->no_telp,
                    'password' => Hash::make($request->password),
                    'role' => $request->role
                ]);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil diedit!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
