<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\ProblemImage;
use App\Models\Tindakan;
use App\Models\TindakanImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
        if ($user->email == $request->email) {
            $rules = [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255'],
                'no_telp' => ['required', 'numeric'],
                'role' => ['required']
            ];
        } else {
            $rules = [
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users'],
                'no_telp' => ['required', 'numeric'],
                'role' => ['required']
            ];
        }

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('user.edit', ['user' => $user->id])->withErrors($validator)->withInput();
        }
        try {
            $data = [
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);
            return redirect()->route('user.index')->with('success', 'Berhasil edit user!');
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
        $problems = Problem::where('user_id',$user->id)->get();
        foreach($problems as $problem){
            $images = ProblemImage::where('problem_id', $problem->id)->get();

            foreach ($images as $image) {
                File::deleteDirectory(public_path('images/problem/' . $image->folder));
            }
            ProblemImage::where('problem_id', $problem->id)->delete();

            $tindakans = Tindakan::where('problem_id', $problem->id)->get();
            foreach ($tindakans as $tindakan) {
                $tindakan_images = TindakanImage::where('tindakan_id', $tindakan->id)->get();
                foreach ($tindakan_images as $tindakan_image) {
                    File::deleteDirectory(public_path('images/tindakan/' . $tindakan_image->folder));
                }
                TindakanImage::where('tindakan_id', $tindakan->id)->delete();
            }
            Tindakan::where('problem_id', $problem->id)->delete();
            if($problem->file != null){
                unlink(public_path('file/' . $problem->file));
            }
            Problem::where('id', $problem->id)->delete();
        }
        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
