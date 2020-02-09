<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * This function get and rename a video
     * @param Video $video
     */
    public function renameVideo(Video $video):void
    {
        $id=$video->id;
        $name=$video->name;
        Video::where('id', $id)->update('name', $name);
    }


    /**
     * This function get and delete a video
     * @param Video $video
     */
    public function deleteVideo(Video $video):void
    {
        $id=$video->id;
        Video::destroy($id);
    }


    /**
     * @param Request $request
     * @param int $project_id
     * @param int $user_id
     */
    public function uploadVideo(Request $request,int $project_id,int $user_id):void
    {
        $video=new Video();
        $video->name = $request->input('name');
        $video->report=array();
        $video->url=$request->file('video')->store(User::findOrFail($user_id));
        $video->project_id=$project_id;
        $video->user_id=$user_id;
        $video->start=0;
        $video->end=;
        $video->framerate=;
        $video->duration=;
        $video->save();
    }

    public function getAllVideosUser(User $user)
    {
        $owned_videos = $user->videos;
        return view('#')->with('videos', $owned_videos);
    }

    public function getAllVideosProject(Project $project)
    {
        $project_videos = $project->videos;
        return view('#')->with('videos', $project_videos);
    }

    public function getReportVideo(int $id)
    {
        $video = Video::find($id);
        return $video->report;
    }
}
