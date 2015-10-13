<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $videos = Video::where('type', 'public')->get();
        return view('videos.index')->with('videos', $videos);
    }
}
