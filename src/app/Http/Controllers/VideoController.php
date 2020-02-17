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
     * @param Video $video The video
     * @param string $name The new name
     */
    public function renameVideo(Video $video, string $name): void
    {
        $video->name = $name;
        $video->save();
    }

    /**
     * This function get and reset a interval of the video
     * @param int $video_id The video
     * @param Request $request The request.
     * @return string A json response.
     */
    public function resetInterval(int $video_id, Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // TODO: Edit
            'start' => 'bail|required',
            'end' => 'required',
            'report' => 'required|json'
        ]);
        if ($validator->fails()) {
            return json_encode(array('done' => false, 'errors' => $validator->errors()->toArray()));
        }

        $video = Video::findOrFail($video_id);
        $video->start = $request->start;
        $video->end = $request->end;
        $video->report = $request->report;
        $video->save();
        return json_encode(array('done' => true));
    }

    /**
     * This function get and delete a video
     * @param Video $video The video.
     * @throws \Exception
     */
    public function deleteVideo(Video $video): void
    {
        $video->delete();
    }


    // public function uploadVideo(Request $request,int $project_id,int $user_id):void
    // {
    //     TODO: To be implemented by Graziano Montanaro
    //     $video=new Video();
    //     $video->name = $request->input('name');
    //     $video->report=array();
    //     $video->url=$request->file('video')->store(User::findOrFail($user_id));
    //     $video->project_id=$project_id;
    //     $video->user_id=$user_id;
    //     $video->start=0;
    //     $video->end=;
    //     $video->framerate=;
    //     $video->duration=;
    //     $video->save();
    // }

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

    /**
     * Get report of a video to analyze.
     * @param int $id The video to be analyzed.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getVideoReport(int $id)
    {
        $current_video = Video::findOrFail($id);
        return view('report-video')
            ->with('video', $current_video)
            ->with('path', ProjectController::getProjectChain($current_video->project))
            ->with('project', $current_video->project);
    }
}
