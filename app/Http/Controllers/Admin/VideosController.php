<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Http\Requests;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\Response;

class VideosController extends Controller
{
    public function index()
    {
        $vids = Video::all();
        return view('admin.videos')->with('videos', $vids);
    }

    public function show($id)
    {
        $vid = Video::findOrFail($id);
        $path = env('FILE_UPLOAD_PATH') . '/' . $vid->id . '~' . $vid->upload_filename;
        $file = File::get($path);

        return (new Response($file, 200))->header('Content-Type', File::mimeType($path));
    }

}
