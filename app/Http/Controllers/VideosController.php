<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Http\Requests;
use App\Models\VideoCategories;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cats = VideoCategories::all()->lists('name','id');
        return view('videos.index')->with('categories', $cats);
    }


    public function byCategory($catId) {
        $cat = VideoCategories::find($catId);
        if ($cat) {
            $vids = Video::where('category_id', $catId)->get();
            return view('videos.by-cat')->with('videos', $vids)->with('category', $cat);
        }
        return redirect("/videos");
    }

    public function preview($vidId) {
        $video = Video::find($vidId);
        if ($video) {
            $category = VideoCategories::find($video->category_id);
            return view('videos.preview')->with('video', $video)->with('category', $category);
        }
        return redirect("/videos");
    }
}
