<?php

namespace Emotionally\Http\Controllers;

use Auth;
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
        return view('home')
            ->with('projects', $this->getAllProjects(Auth::user()));
    }

    /**
     * Get the view with all the projects' content.
     * @param int $id The id of the project.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The project's details view
     */
    public function getProjectDetails(int $id)
    {
        $current_project = Project::findOrFail($id);
        return view('project')
            ->with('project', $current_project)
            ->with('path', $this->getProjectChain($current_project))
            ->with('subprojects', $current_project->sub_projects)
            ->with('videos', $current_project->videos);
    }

    /**
     * Get the chain of "father projects" to get to a given project.
     * @param Project $project The project.
     * @return array The chain of projects. The last element of this array is the project given as input
     */
    public static function getProjectChain(Project $project)
    {
        $chain = array();
        array_unshift($chain, $project);
        while ($project = $project->father_project) {
            array_unshift($chain, $project);
        }
        return $chain;
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
     * This public function allow to rename the project.
     * @param Project $project The project
     * @param string $name The new name of the project.
     */
    public function renameProject(Request $request): void
    {
        $name = $request->input('project_name','cacca');
        $project=Project::findOrFail($request->input('project_rename_id'));
        $project->name = $name;
        $project->save();
    }

    /**
     * This public function allow to delete the project.
     * @param Project $project The project
     */
    public function deleteProject(Request $request)
    {
        $id = $request->input('project_delete_id');
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect(route('system.home'));
    }

    /**
     *
     * @param Project $project
     */
    public function moveProject(Project $project): void
    {
        $project->father_id = null;
        $project->save();
    }

    /**
     * Create a project via an HTTP request.
     * @param Request $request The HTTP request received by the form.
     */
    public function createProject(Request $request){
        $project = new Project();
        $project->name = $request->input('project_name');
        $project->user_id = Auth::user()->id;
        if($request->has('father_id'))
            $project->father_id = $request->input('father_id');
        $project->save();
    }

}
