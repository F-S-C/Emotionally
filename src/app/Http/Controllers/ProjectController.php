<?php

namespace Emotionally\Http\Controllers;

use Emotionally\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getProjectsList(){
        return view('home')->with('projects', $this->getAllProjects(User::first()));
    }

    private function getAllProjects($user){
        return $user->projects;
    }
}
