<?php

namespace App\Http\Controllers;

use App\FileUploader\FileUploaderPublisher;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Video;
use App\Http\Requests\CreateVideoRequest;
use Auth;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\Response;

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
//        $this->middleware('auth');
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
     * @param  CreateVideoRequest  $request
     * @return Response
     */
    public function store(CreateVideoRequest $request)
    {
        $params = $request->except(['video', '_token']);
        $vid = $request->file('video');

        $params = $this->setVideoParams($params, $vid);
        $video= Video::create($params);
        $this->uploader->pushFile($vid, $video, $params['original_filename'], $params['upload_filename']);
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
    public function update(CreateVideoRequest $request, $id)
    {
        $params = $request->except(['video', '_token']);
        $newVideo = $request->file('video');

        if ($newVideo) {
            $params = $this->setVideoParams($params, $newVideo);
        }
        $existingVideo = Video::findOrFail($id);

        if ($existingVideo) {
            if ($newVideo) {
                $formerFile = $existingVideo->upload_filename; //to be deleted
            }
            $existingVideo->update($params);

            if ($newVideo) {
                $this->uploader->pushFile($newVideo, $existingVideo, $params['original_filename'], $params['upload_filename'], $formerFile);
            }
        }

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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $vid = Video::findOrFail($id);
        $path = env('FILE_UPLOAD_PATH') . '/' . $vid->id . '~' . $vid->upload_filename;
        $file = File::get($path);

        return (new Response($file, 200))->header('Content-Type', File::mimeType($path));
    }

    private function setVideoParams($params, $vid) {
        $params['mime_type'] = $vid->getClientMimeType();
        $params['original_filename'] = $vid->getClientOriginalName();
        $params['upload_filename'] = md5($vid->getClientOriginalName()) . '.' . $vid->getClientOriginalExtension();

        return $params;
    }
}
