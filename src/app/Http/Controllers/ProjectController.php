<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getProjectsList()
    {
        return view('home')->with('projects', $this->getAllProjects(User::first())); //auth()->user()
    }

    private function getAllProjects(User $user)
    {
        $owned_projects = $user->projects->where('father_id', null);
        $shared_projects = $user->permissions;

        return $owned_projects->merge($shared_projects);
    }

}
