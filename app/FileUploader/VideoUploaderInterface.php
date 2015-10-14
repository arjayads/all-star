<?php namespace App\FileUploader;

use App\Http\Requests\CreateVideoRequest;

interface VideoUploaderInterface {

    public function pushFile($videoFile, $videoId, $originalFilename, $newFilename, $formerFile);

}
