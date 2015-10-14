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

    public function pushFile($videoFile, $video, $originalFilename, $newFilename, $formerFile = null)
    {
        if($videoFile) {
            try {
                $finalFn = $video->id . '~' . $newFilename;
                $this->deleteFile($this->getPath() . '/' . $finalFn); // delete same file
                $videoFile->move($this->getPath(), $finalFn);

                if ($formerFile != null && strcmp($formerFile, $newFilename) !== 0) {
                    $this->deleteFile($this->getPath()  . '/' . $video->id . '~' . $formerFile); // delete former file
                }

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