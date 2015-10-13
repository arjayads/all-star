<?php namespace App\FileUploader;

use App\Http\Requests\CreateVideoRequest;
use Illuminate\Support\Facades\File;

class FileUploaderPublisher implements VideoUploaderInterface
{
    private $path;

    /**
     * Set the default path.
     */
    public function __construct()
    {
        $this->path = env('FILE_UPLOAD_PATH');
    }

    public function pushFile($videoFile, $videoId, $originalFilename, $newFilename)
    {
        if($videoFile) {

            try {
                $finalFn = $videoId . '~' . $newFilename;
                $this->deleteFile($this->getPath() . $finalFn);
                $videoFile->move($this->getPath(), $finalFn);

            } catch (\Exception $x) {
                throw new \RuntimeException($x);
            }
        }
    }

    public function deleteFile($path)
    {
        File::delete($path);
    }

    /**
     * Get the path of videos folder.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path of videos folder.
     *
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

}