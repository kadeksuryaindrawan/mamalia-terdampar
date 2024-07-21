<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\ProblemImage;
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
            'oleh' => ['required', 'string', 'max:255'],
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
                'oleh' => $request->oleh,
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
            return redirect()->route('tindakan-index')->with('success', 'Penanganan berhasil ditambah!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detail($problem_id)
    {
        $problem = Problem::find($problem_id);
        $problem_images = ProblemImage::where('problem_id', $problem_id)->get();
        $tindakans = Tindakan::where('problem_id',$problem_id)->orderBy('created_at','asc')->get();
        $tindakan_images = [];
        foreach ($tindakans as $tindakan) {
            $tindakan_id = $tindakan->id;
            $images = TindakanImage::where('tindakan_id', $tindakan_id)->get();
            $tindakan_images[$tindakan_id] = $images;
        }
        return view('tindakan.detail',compact('tindakans','problem','tindakan_images','problem_images'));
    }

    public function tindakanterakhir($problem_id)
    {
        $problem = Problem::find($problem_id);
        $problem_images = ProblemImage::where('problem_id', $problem_id)->get();
        $tindakans = Tindakan::where('problem_id', $problem_id)->orderBy('created_at', 'asc')->get();
        $tindakan_images = [];
        foreach ($tindakans as $tindakan) {
            $tindakan_id = $tindakan->id;
            $images = TindakanImage::where('tindakan_id', $tindakan_id)->get();
            $tindakan_images[$tindakan_id] = $images;
        }
        return view('tindakan.tindakanterakhir', compact('tindakans', 'problem', 'tindakan_images','problem_images'));
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
            'oleh' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('tindakan-edit', $id)->withErrors($validator)->withInput();
        }

        try {
            $tindakan->update([
                'tindakan' => $request->tindakan,
                'oleh' => $request->oleh,
            ]);
            return redirect()->route('tindakan-detail',$tindakan->problem_id)->with('success', 'Penanganan berhasil diedit!');
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
        return redirect()->route('tindakan-detail',$tindakan->problem_id)->with('success', 'Foto Penanganan berhasil diedit!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $tindakan = Tindakan::find($id);
        $images = TindakanImage::where('tindakan_id', $tindakan->id)->get();
        $problem_id = $tindakan->problem_id;
        $tindakan_problem_count = Tindakan::where('problem_id',$problem_id)->count();

        foreach ($images as $image) {
            File::deleteDirectory(public_path('images/tindakan/' . $image->folder));
        }
        TindakanImage::where('tindakan_id', $tindakan->id)->delete();

        if($tindakan_problem_count == 1){
            $tindakan->delete();
            $problem = Problem::find($problem_id);
            Problem::where('id',$problem_id)->update([
                'status' => 'belum ditangani'
            ]);
            if($problem->file !== null) {
                unlink(public_path('file/' . $problem->file));
            }
        }else{
            $tindakan->delete(public_path($image->folder));
        }

        return redirect()->back()->with('success', 'Penanganan berhasil dihapus!');
    }

    public function selesai(Request $request)
    {
        if (Auth::user()->role == 'westerlaken') {
            return back();
        }
        $problem = Problem::find($request->problem_id);

        $validator = Validator::make($request->all(), [
            'file' => ['required', 'file', 'mimes:pdf'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('tindakan-index')->with('error', 'File yang diupload harus pdf!');
        }
        try {
            if ($request->hasFile('file')) {
                $file = md5(time()) . '_File_Penanganan_Selesai_' . $request->file('file')->getClientOriginalName();
                $destinationPath = public_path('file');
                $request->file('file')->move($destinationPath, $file);
                $problem->update([
                    'status' => 'selesai ditangani',
                    'file' => $file
                ]);
            }

            return redirect()->route('tindakan-index')->with('success', 'Penanganan berhasil diselesaikan!');
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
