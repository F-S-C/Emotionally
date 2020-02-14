<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * This function get and delete a video
     * @param Video $video The video.
     * @throws \Exception
     */
    public function deleteVideo(Video $video): void
    {
        $video->delete();
    }

    private function getVideoPath($project_id)
    {
        $current_project = Project::findOrFail($project_id);
        $path = $current_project->id . '/';
        while ($project = $current_project->father_project) {
            $path = $project->id . '/' . $path;
        }
        return 'user-content/' . \Auth::user()->id . '/' . $path;
    }


    public function uploadVideo(Request $request)
    {
        $getID3 = new \getID3;
        $files = $request->file('videos');
        if ($request->hasFile('videos')) {
            foreach ($files as $to_upload) {
                $filename = $to_upload->hashName();
                $file = $getID3->analyze($to_upload->getRealPath());

                $to_upload->move('user-content', $filename);
                $duration = date('H:i:s', $file['playtime_seconds']);

                $video = new Video();
                $video->name = pathinfo($to_upload->getClientOriginalName(), PATHINFO_FILENAME);
//                $video->report = ""; //TODO: Integrare con affdex.js
                $video->url = 'user-content';
                $video->project_id = $request->input('project_id');
                $video->user_id = auth()->user()->id;
                $video->start = '00:00:00';
                $video->framerate = $request->input('framerate');
                $video->duration = $duration;
                $video->end = $duration;
                $video->save();
            }
            echo '{"result":true}';
        }else{
            echo '{"result":false}';
        }
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
