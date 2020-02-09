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
     * @return false|string
     */
    public function uploadVideo(Request $request):void
    {
        $name = $request->input('name');
        $report=$request->input('report');
        $path=$request->file('video')->store('public');
        
    }









}
