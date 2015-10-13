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

    public function pushFile($id, $filename, CreateVideoRequest $request)
    {
        if($request->file('video')) {

            try {
                $localFilename = $id . '~' . $filename;
                $this->deleteFile($this->getPath() . $localFilename);
                $request->file('video')->move($this->getPath(), $localFilename);

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