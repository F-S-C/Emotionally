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

    function addPermission($project_id, Request $request)
    {
        $validator = \Validator::make($request->all(),[
            'email'=>'bail|required|email|exists:users,email',
            'modify'=>'in:true,false',
            'add'=>'in:true,false',
            'remove'=>'in:true,false',
        ])->validate();
        $current_project = Project::findOrFail($project_id);
        $user = User::whereEmail($request->email)->get()->first();

        $current_project->users()->attach($user['id'], [
            'read' => true,
            'modify' => (bool)$request->modify ?? false,
            'add' => (bool)$request->add ?? false,
            'remove' => (bool)$request->remove ?? false
        ]);
        return redirect(route('system.permissions.index', ['project_id' => $project_id]));
    }

    function deletePermission($project_id, $user_id)
    {
        Project::findOrFail($project_id)->users()->detach($user_id);
        return redirect(route('system.permissions.index', ['project_id' => $project_id]));
    }
}
