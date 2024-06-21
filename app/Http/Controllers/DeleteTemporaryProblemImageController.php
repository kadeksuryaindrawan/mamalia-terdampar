<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryImage;
use Illuminate\Support\Facades\File;

class DeleteTemporaryProblemImageController extends Controller
{
    public function __invoke()
    {
        $temporary_image = TemporaryImage::where('folder', request()->getContent())->first();
        if ($temporary_image) {
            $directoryPath = public_path('images/tmp/' . $temporary_image->folder);

            File::deleteDirectory($directoryPath);
            File::deleteDirectory(public_path('images/problem/' . $temporary_image->folder));
            $temporary_image->delete();
        }
        return response()->noContent();
    }
}
