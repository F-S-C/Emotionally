<?php

namespace Emotionally\Http\Controllers;

use Emotionally\Project;
use Emotionally\User;
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

    function deletePermission($project_id, $user_id)
    {
        Project::findOrFail($project_id)->users()->detach($user_id);
        return redirect(route('system.permissions.index', ['project_id' => $project_id])) ;
    }
}
