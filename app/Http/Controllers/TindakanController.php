<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\Tindakan;
use App\Models\TindakanImage;
use App\Models\TindakanTemporaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakans = Tindakan::select('problem_id', DB::raw('MAX(created_at) as max_created_at'))
        ->groupBy('problem_id')
        ->orderBy('max_created_at', 'desc')
        ->get();
        return view('tindakan.index',compact('tindakans'));
    }

    public function create($problem_id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $problem = Problem::find($problem_id);
        return view('tindakan.add',compact('problem'));
    }

    public function store(Request $request, $problem_id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $validator = Validator::make($request->all(), [
            'tindakan' => ['required', 'string'],
        ]);

        $temporary_images = TindakanTemporaryImage::all();

        if ($validator->fails()) {
            foreach ($temporary_images as $temporary_image) {
                $directoryPath = public_path('images/tindakan_tmp/' . $temporary_image->folder);

                File::deleteDirectory($directoryPath);
                $temporary_image->delete();
            }
            return redirect()->route('tindakan-create')->withErrors($validator)->withInput();
        }

        try {
            $tindakan = Tindakan::create([
                'problem_id' => $problem_id,
                'tindakan' => $request->tindakan,
            ]);

            foreach ($temporary_images as $temporary_image) {
                File::copy(public_path('images/tindakan_tmp/' . $temporary_image->folder . '/' . $temporary_image->file), public_path('images/tindakan/' . $temporary_image->folder . '/' . $temporary_image->file));
                TindakanImage::create([
                    'tindakan_id' => $tindakan->id,
                    'name' => $temporary_image->file,
                    'folder' => $temporary_image->folder
                ]);
                $directoryPath = public_path('images/tindakan_tmp/' . $temporary_image->folder);

                File::deleteDirectory($directoryPath);
                $temporary_image->delete();
            }
            Problem::where('id',$problem_id)->update([
                'status' => 'proses penanganan'
            ]);
            return redirect()->route('tindakan-index')->with('success', 'Tindakan berhasil ditambah!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail($problem_id)
    {
        $problem = Problem::find($problem_id);
        $tindakans = Tindakan::where('problem_id',$problem_id)->orderBy('created_at','asc')->get();
        $tindakan_images = [];
        foreach ($tindakans as $tindakan) {
            $tindakan_id = $tindakan->id;
            $images = TindakanImage::where('tindakan_id', $tindakan_id)->get();
            $tindakan_images[$tindakan_id] = $images;
        }
        return view('tindakan.detail',compact('tindakans','problem','tindakan_images'));
    }

    public function tindakanterakhir($problem_id)
    {
        $problem = Problem::find($problem_id);
        $tindakans = Tindakan::where('problem_id', $problem_id)->orderBy('created_at', 'asc')->get();
        $tindakan_images = [];
        foreach ($tindakans as $tindakan) {
            $tindakan_id = $tindakan->id;
            $images = TindakanImage::where('tindakan_id', $tindakan_id)->get();
            $tindakan_images[$tindakan_id] = $images;
        }
        return view('tindakan.tindakanterakhir', compact('tindakans', 'problem', 'tindakan_images'));
    }

    public function edit($id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        return view('tindakan.edit',compact('tindakan'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        $validator = Validator::make($request->all(), [
            'tindakan' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('tindakan-edit', ['tindakan' => $id])->withErrors($validator)->withInput();
        }

        try {
            $tindakan->update([
                'tindakan' => $request->tindakan,
            ]);
            return redirect()->route('tindakan-detail',$tindakan->problem_id)->with('success', 'Tindakan berhasil diedit!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function editfototindakan($id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        return view('tindakan.editimg', compact('tindakan'));
    }

    public function editfototindakanproses(Request $request, $id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        $request->validate([
            'image' => ['required']
        ]);

        $temporary_images = TindakanTemporaryImage::all();

        $images = TindakanImage::where('tindakan_id', $id)->get();
        if ($images->count() > 0) {
            foreach ($images as $image) {
                File::deleteDirectory(public_path('images/tindakan/' . $image->folder));
            }
            TindakanImage::where('tindakan_id', $id)->delete();
        }

        foreach ($temporary_images as $temporary_image) {
            File::copy(public_path('images/tindakan_tmp/' . $temporary_image->folder . '/' . $temporary_image->file), public_path('images/tindakan/' . $temporary_image->folder . '/' . $temporary_image->file));
            TindakanImage::create([
                'tindakan_id' => $id,
                'name' => $temporary_image->file,
                'folder' => $temporary_image->folder
            ]);
            $directoryPath = public_path('images/tindakan_tmp/' . $temporary_image->folder);

            File::deleteDirectory($directoryPath);
            $temporary_image->delete();
        }
        return redirect()->route('tindakan-detail',$tindakan->problem_id)->with('success', 'Foto Tindakan berhasil diedit!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        $images = TindakanImage::where('tindakan_id', $tindakan->id)->get();

        foreach ($images as $image) {
            File::deleteDirectory(public_path('images/tindakan/' . $image->folder));
        }
        TindakanImage::where('tindakan_id', $tindakan->id)->delete();

        $tindakan->delete();

        return redirect()->back()->with('success', 'Tindakan berhasil dihapus!');
    }

    public function selesai($id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $problem = Problem::find($id);

        $problem->update([
            'status' => 'selesai ditangani'
        ]);

        return redirect()->back()->with('success', 'Tindakan berhasil diselesaikan!');
    }
}
