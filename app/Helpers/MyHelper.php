<?php namespace App\Helpers;

use App\Models\File;
use Intervention\Image\Facades\Image;

class MyHelper {

    static function getImageFromStorage($id, $filename) {
        return env('FILE_UPLOAD_PATH') . '/' . $eventId . '~' . $filename;
    }

    static function getImageAsResponse($id, $imageId , $size = 0)
    {
        $file = File::find($imageId);

        if ($file) {
            try {
                $path = self::getImageFromStorage($eventId, $file->new_filename);
                $img = Image::make($path);

                if ($size > 0) {
                    $img->resize($size, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                return response($img->encode($img->extension), 200)->header('Content-Type', $img->mime);

            }catch (\Exception $e) {
                return new \RuntimeException($e);
            }
        }
    }
} 