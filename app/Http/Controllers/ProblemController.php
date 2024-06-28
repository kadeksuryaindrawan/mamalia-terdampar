<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\ProblemImage;
use App\Models\TemporaryImage;
use App\Models\Tindakan;
use App\Models\TindakanImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'admin' || Auth::user()->role == 'yayasan'){
            $problems = Problem::orderBy('created_at', 'desc')->get();
        }
        if(Auth::user()->role == 'pelapor'){
            $problems = Problem::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        }

        return view('masalah.index', compact('problems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            return view('masalah.add');
        }else{
            return back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $validator = Validator::make($request->all(), [
                'masalah' => ['required', 'string', 'max:255'],
                'uraian' => ['required', 'string'],
                'alamat_kejadian' => ['required', 'string'],
            ]);

            $temporary_images = TemporaryImage::all();

            if ($validator->fails()) {
                foreach ($temporary_images as $temporary_image) {
                    $directoryPath = public_path('images/tmp/' . $temporary_image->folder);

                    File::deleteDirectory($directoryPath);
                    $temporary_image->delete();
                }
                return redirect()->route('masalah.create')->withErrors($validator)->withInput();
            }

            try {
                $problem = Problem::create([
                    'user_id' => Auth::user()->id,
                    'masalah' => $request->masalah,
                    'uraian' => $request->uraian,
                    'alamat_kejadian' => $request->alamat_kejadian,
                    'status' => 'belum ditangani',
                ]);

                foreach ($temporary_images as $temporary_image) {
                    File::copy(public_path('images/tmp/' . $temporary_image->folder . '/' . $temporary_image->file), public_path('images/problem/' . $temporary_image->folder . '/' . $temporary_image->file));
                    ProblemImage::create([
                        'problem_id' => $problem->id,
                        'name' => $temporary_image->file,
                        'folder' => $temporary_image->folder
                    ]);
                    $directoryPath = public_path('images/tmp/' . $temporary_image->folder);

                    File::deleteDirectory($directoryPath);
                    $temporary_image->delete();
                }
                return redirect()->route('masalah.index')->with('success', 'Masalah berhasil ditambah!');
            } catch (\Throwable $th) {
                throw $th;
            }
        }else{
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $problem = Problem::find($id);
        $images = ProblemImage::where('problem_id', $id)->get();
        return view('masalah.detail', compact('problem','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $problem = Problem::find($id);
            return view('masalah.edit', compact('problem'));
        }else{
            return back();
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $problem = Problem::find($id);

            $validator = Validator::make($request->all(), [
                'masalah' => ['required', 'string', 'max:255'],
                'uraian' => ['required', 'string'],
                'alamat_kejadian' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return redirect()->route('masalah.edit', ['problem' => $id])->withErrors($validator)->withInput();
            }

            try {
                $problem->update([
                    'masalah' => $request->masalah,
                    'uraian' => $request->uraian,
                    'alamat_kejadian' => $request->alamat_kejadian,
                ]);
                return redirect()->route('masalah.index')->with('success', 'Masalah berhasil diedit!');
            } catch (\Throwable $th) {
                throw $th;
            }
        }else{
            return back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Problem  $problem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $problem = Problem::find($id);
            $images = ProblemImage::where('problem_id', $problem->id)->get();

            foreach ($images as $image) {
                File::deleteDirectory(public_path('images/problem/' . $image->folder));
            }
            ProblemImage::where('problem_id', $problem->id)->delete();

            $tindakans = Tindakan::where('problem_id',$problem->id)->get();
            foreach($tindakans as $tindakan){
                $tindakan_images = TindakanImage::where('tindakan_id', $tindakan->id)->get();
                foreach ($tindakan_images as $tindakan_image) {
                    File::deleteDirectory(public_path('images/tindakan/' . $tindakan_image->folder));
                }
                TindakanImage::where('tindakan_id', $tindakan->id)->delete();
            }
            Tindakan::where('problem_id',$problem->id)->delete();
            $problem->delete();

            return redirect()->back()->with('success', 'Masalah berhasil dihapus!');
        }else{
            return back();
        }

    }

    public function editfotomasalah($id)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $problem = Problem::find($id);
            return view('masalah.editimg', compact('problem'));
        }else{
            return back();
        }

    }

    public function editfotomasalahproses(Request $request, $id)
    {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'pelapor') {
            $request->validate([
                'image' => ['required']
            ]);

            $temporary_images = TemporaryImage::all();

            $images = ProblemImage::where('problem_id', $id)->get();
            if ($images->count() > 0) {
                foreach ($images as $image) {
                    File::deleteDirectory(public_path('images/problem/' . $image->folder));
                }
                ProblemImage::where('problem_id', $id)->delete();
            }

            foreach ($temporary_images as $temporary_image) {
                File::copy(public_path('images/tmp/' . $temporary_image->folder . '/' . $temporary_image->file), public_path('images/problem/' . $temporary_image->folder . '/' . $temporary_image->file));
                ProblemImage::create([
                    'problem_id' => $id,
                    'name' => $temporary_image->file,
                    'folder' => $temporary_image->folder
                ]);
                $directoryPath = public_path('images/tmp/' . $temporary_image->folder);

                File::deleteDirectory($directoryPath);
                $temporary_image->delete();
            }
            return redirect()->route('masalah.index')->with('success', 'Foto Masalah berhasil diedit!');
        }else{
            return back();
        }
    }
}
