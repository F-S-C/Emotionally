<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Output\ConsoleOutput;

class VideoController extends Controller
{
    /**
     * This function get and delete a video
     * @param Video $video The video.
     * @throws \Exception
     */
    public function deleteVideo(Video $video): void
    {
        $video->delete();
    }

    /**
     * This public function allow to rename video.
     * @param Request $request The HTTP request
     */
    public function renameVideo(Request $request): void
    {
        $name = $request->input('video_name', 'NO_NAME');
        $video = Video::findOrFail($request->input('video_rename_id'));
        $video->name = $name;
        $video->save();
    }

    /**
     * Returns the path of the video.
     * @param $project_id The id of the video.
     * @return string The path.
     */
    private function getVideoPath($project_id)
    {
        $current_project = Project::findOrFail($project_id);
        $path = $current_project->id . '/';
        while ($project = $current_project->father_project) {
            $path = $project->id . '/' . $path;
        }
        return 'user-content/' . \Auth::user()->id . '/' . $path;
    }

    /**
     * Set the report field for a video.
     * @param Request $request The request. It must contain the report and the id of the video.
     * @return false|string A json response.
     */
    public function setReport(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'video_id' => 'bail|required|integer|exists:videos,id',
            'report' => 'required|json',
        ]);
        if ($validator->fails()) {
            return json_encode(array('done' => false, 'errors' => $validator->errors()->toArray()));
        }

        $video = Video::findOrFail($request->video_id);
        $video->report = trim($request->report);
        $video->save();

        return json_encode(array('done' => true));
    }

    /**
     * Upload and manages the video passed through HTTP request.
     * @param Request $request The HTTP request.
     * @throws \getid3_exception \\getid3_exception
     */
    public function uploadVideo(Request $request)
    {
        $getID3 = new \getID3;
        $files = $request->file('videos');
        if ($request->hasFile('videos')) {
            $urls = array();
            foreach ($files as $to_upload) {
                $filename = $to_upload->hashName();
                $file = $getID3->analyze($to_upload->getRealPath());

                $to_upload->move('user-content', $filename);
                $duration = date('H:i:s', $file['playtime_seconds']);

                $video = new Video();
                $video->name = pathinfo($to_upload->getClientOriginalName(), PATHINFO_FILENAME);
                $video->report = "";
                $video->url = asset('user-content/' . $filename);
                $video->project_id = $request->input('project_id');
                $video->user_id = auth()->user()->id;
                $video->start = '00:00:00';
                $video->framerate = $request->input('framerate');
                $video->duration = $duration;
                $video->end = $duration;
                $video->save();
                array_push($urls, array('url' => $video->url, 'id' => $video->id));
            }
            echo json_encode(array('result' => true, 'files' => $urls));
        } else {
            echo json_encode(array('result' => false));
        }
    }

    /**
     * Inserts a realtime video sent via a base64 form.
     * @param Request $request The HTTP request.
     * @return false|string The result of the operation.
     */
    public function realtimeUpload(Request $request)
    {
        $out = new ConsoleOutput();
        $video = new Video();
        $urls = array();
        if ($request->has('video')) {
            $to_upload = $request->file('video');
            try {
                $out->writeln($to_upload->getRealPath());
                $getID3 = new \getID3;

                $filename = $to_upload->hashName();
                $file = $getID3->analyze($to_upload->getRealPath());

                $to_upload->move('user-content', $filename);
                $out->writeln(json_encode($file));
                $duration = date('H:i:s', $file['playtime_seconds']);

                $video->project_id = $request->input('project_id');
                $video->framerate = $request->input('framerate');
                $video->name = $request->input('title');
                $video->user_id = auth()->user()->id;
                $video->start = '00:00:00';
                $out->writeln($filename);
                $video->url = asset('user-content/' . $filename);
                $video->duration = $duration;
                $video->end = $duration;
                $video->save();
                array_push($urls, array('url' => $video->url, 'id' => $video->id));
                return json_encode(array('result' => true, 'files' => $urls));
            } catch (\Exception $e) {
                echo json_encode(array('result' => false, 'error' => $e->getMessage()));
            }
        } else {
            echo json_encode(array('result' => false));
        }
    }

    /**
     * Returns a user's videos.
     * @param User $user The user.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view with videos
     */
    public function getAllVideosUser(User $user)
    {
        $owned_videos = $user->videos;
        return view('#')->with('videos', $owned_videos);
    }

    /**
     * Returns the videos of a project.
     * @param Project $project The project.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The view with videos.
     */
    public function getAllVideosProject(Project $project)
    {
        $project_videos = $project->videos;
        return view('#')->with('videos', $project_videos);
    }

    /**
     * Returns the report of a video.
     * @param int $id The video id.
     * @return mixed The report.
     */
    public function getReportVideo(int $id)
    {
        $video = Video::find($id);
        return $video->report;
    }
}
