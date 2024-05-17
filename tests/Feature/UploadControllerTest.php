<?php

namespace Tests\Feature;

use App\Http\Controllers\UploadController;
use App\Http\Requests\Uploadfile;
use App\Jobs\ProcessFilesJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{
    public function testShouldTriggerTheJob(): void
    {
        Queue::fake();

        $uploadController = new UploadController();
        $request = new Uploadfile();
		$request->files->set('file', UploadedFile::fake()->create('index.csv'));
        $uploadController->upload($request);

        Queue::assertPushed(ProcessFilesJob::class);
    }
}
