<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TindakanTemporaryImage;
use Illuminate\Support\Facades\File;

class DeleteTemporaryTindakanImageController extends Controller
{
    public function __invoke()
    {
        $temporary_image = TindakanTemporaryImage::where('folder', request()->getContent())->first();
        if ($temporary_image) {
            $directoryPath = public_path('images/tindakan_tmp/' . $temporary_image->folder);

            File::deleteDirectory($directoryPath);
            File::deleteDirectory(public_path('images/tindakan/' . $temporary_image->folder));
            $temporary_image->delete();
        }
        return response()->noContent();
    }
}
