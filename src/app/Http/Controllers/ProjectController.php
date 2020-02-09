<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
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

}
