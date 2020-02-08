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
     * Get the view with all the current user's projects.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The dashboard view.
     */
    public function getDashboard()
    {
        return view('home')->with('projects', $this->getAllProjects(User::first())); //auth()->user()
    }

    /**
     * Get a list of all the projects of a user. This includes the projects of
     * which a user is owner and those that were shared with the same user.
     * @param User $user The user "owner" of the projects.
     * @return Project[]|\Illuminate\Database\Eloquent\Collection|mixed The projects.
     */
    private function getAllProjects(User $user)
    {
        $owned_projects = $user->projects->where('father_id', null);
        $shared_projects = $user->permissions;

        return $owned_projects->merge($shared_projects);
    }

    /**
     * This function get and rename a video
     * @param Video $video
     */
    public function renameVideo(Video $video)
    {
        $id=$video->id;
        $name=$video->name;
        Video::where('id', $id)->update('name', $name);
    }


    /**
     * This function get and delete a video
     * @param Video $video
     */
    public function deleteVideo(Video $video)
    {
        $id=$video->id;
        Video::destroy($id);
    }


    public function uploadVideo(Request $request)
    {
        echo $request->file('video')->store('public');
    }



}
