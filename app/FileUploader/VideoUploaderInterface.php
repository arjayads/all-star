<?php namespace App\FileUploader;

use App\Http\Requests\CreateVidoeRequest;

interface VideoUploaderInterface {

    public function pushFile($id, CreateVidoeRequest $request);

}
