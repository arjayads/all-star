<?php

namespace App\Http\Controllers;

use App\FileUploader\FileUploaderPublisher;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\services\Video;
use App\Http\Requests\CreateVidoeRequest;
use Auth;

class AdminController extends Controller
{
    /**
     * @var FileUploaderPublisher
     */
    private $uploader;

    /**
     * @param FileUploaderPublisher $uploader
     */
    public function __construct(FileUploaderPublisher $uploader)
    {
        $this->uploader = $uploader;    
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $videos = Video::all();

        return view('admin.videos')->with('videos', $videos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateVidoeRequest  $request
     * @return Response
     */
    public function store(CreateVidoeRequest $request)
    {
        $video= Video::create($request->all());
        $this->uploader->pushFile($video->id, $request);
        return redirect('admin/videos');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);

        return view('admin.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CreateVidoeRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->update($request->all());
        $this->uploader->pushFile($id, $request);

        return redirect('admin/videos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {

        Video::deleted($id);
    }
}
