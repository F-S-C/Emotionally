<?php
/**
 * This file is part of Emotionally.
 *
 * Emotionally is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Emotionally is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Emotionally.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Emotionally\Http\Controllers;
use Emotionally\Project;
use Emotionally\User;
use Emotionally\Video;
use Illuminate\Http\Request;



class ReportController extends Controller
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
        $video->url=$request->file('video')->store('public');
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


    public function avarage(array $json)
    {
        $iterated=0;
        $a=0;
        $b=0;
        $c=0;
        $d=0;
        $e=0;
        $f=0;
        $g=0;
            foreach ($json as $row)
            {
                $a=$row['a']+$a;
                $b=$row['a']+$b;
                $c=$row['a']+$c;
                $d=$row['a']+$d;
                $e=$row['a']+$e;
                $f=$row['a']+$f;
                $g=$row['a']+$g;
                $iterated++;
            }
        $avarageReport = [
            'a' => $a/$iterated,
            'b' => $b/$iterated,
            'c' => $c/$iterated,
            'd' => $d/$iterated,
            'e' => $e/$iterated,
            'f' => $f/$iterated,
            'g' => $g/$iterated
        ];
            return $avarageReport;
    }












}
