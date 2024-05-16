<?php

namespace App\Http\Controllers;

use App\Http\Requests\Uploadfile;
use App\Jobs\ProcessFilesJob;
use Exception;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    public function __invoke(Uploadfile $request)
    {
        try {
            $file = $request->file('file');
            Storage::put("files", $file);
            ProcessFilesJob::dispatch(storage_path('app/files/').$file->hashName())->onQueue('process_files');

            return response()->json([
                $file->hashName()
            ]);
        } catch(Exception $error) {
            return response()->json([
                $error->getMessage()
            ]);
        }
    }
}
