<?php

namespace App\Http\Controllers;

use App\Models\TindakanTemporaryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UploadTemporaryTindakanImageController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->guessExtension();

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                return response()->json(['error' => 'Hanya file gambar yang diizinkan.'], 422);
            } else {
                $image = $request->file('image');
                $filename = md5(time()) . "-" . "tindakan." . $image->getClientOriginalExtension();
                $folder = uniqid('image-', true);
                $destinationDirectory = public_path('images/tindakan/' . $folder);
                if (!File::exists($destinationDirectory)) {
                    File::makeDirectory($destinationDirectory, 0755, true);
                }
                $image->move('images/tindakan_tmp/' . $folder, $filename);

                $temporary = TindakanTemporaryImage::create([
                    'folder' => $folder,
                    'file' => $filename
                ]);

                return $folder;
            }
        }
        return '';
    }
}
