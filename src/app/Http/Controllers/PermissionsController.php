<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    function getProjectPermissions($project_id)
    {
        $current_project = Project::findOrFail($project_id);
        return view('project-share')
            ->with('project', $current_project)
            ->with('path', ProjectController::getProjectChain($current_project));
    }
}
