<?php namespace App\FileUploader;

use App\Http\Requests\CreateVideoRequest;
use Illuminate\Support\Facades\File;

class FileUploaderPublisher implements VideoUploaderInterface
{
    private $path;

    private $fileName;

    /**
     * Set the default path.
     */
    public function __construct()
    {
        $this->path = env('FILE_UPLOAD_PATH');
    }

    public function pushFile($id, CreateVideoRequest $request)
    {
        if($request->file('filename')) {
            $this->fileName = $id . '.' . $request->file('filename')->getClientOriginalExtension();

            $this->deleteFile(base_path() . $this->getPath() . $this->fileName);

            $request->file('filename')->move(
                base_path() . $this->getPath(), $this->fileName
            );
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