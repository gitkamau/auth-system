<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Video;

class VideoController extends ApiController
{
    public function store(Request $request)
    {
        $path = $request->file('video')->store('videos', 's3');

        $video = new Video;
        $video->title = $request->title;
        $video->url = Storage::disk('s3')->url($path);
        $video->project_id = $request->project_id;
        $video->save();

        return response()->json($video, 201);
    }
}