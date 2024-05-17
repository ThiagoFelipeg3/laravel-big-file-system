<?php

namespace Tests\Feature;

use App\Http\Controllers\UploadController;
use App\Http\Requests\Uploadfile;
use App\Jobs\ProcessFilesJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    public function testShouldTriggerTheJob(): void
    {
        Queue::fake();

        $uploadController = new UploadController();
        $request = new Uploadfile();
        $file = UploadedFile::fake()->create('index.csv');
		$request->files->set('file', $file);
        $uploadController->upload($request);

        Queue::assertPushed(ProcessFilesJob::class);
        Storage::disk('local')->delete('files/'.$file->hashName());
    }

    public function testShouldCallStorage(): void
    {
        Storage::fake('test');

        $uploadController = new UploadController();
        $request = new Uploadfile();
        $file = UploadedFile::fake()->create('index.csv');
		$request->files->set('file', $file);
        $uploadController->upload($request)->getData();

        Storage::disk('local')->assertExists('files/'.$file->hashName());
        Storage::disk('local')->delete('files/'.$file->hashName());
    }
}