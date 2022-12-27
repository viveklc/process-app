<?php

namespace App\Http\Controllers\DMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\DMS\StoreProjectRequest;
use App\Http\Requests\DMS\UpdateProjectRequest;
use App\Models\DMS\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!auth()->user()->can('read-projects'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::query()
                ->isActive()
                ->orderBy('project_name')
                ->paginate(config('app-config.datatable_default_row_count'));

        return view('dms.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('dms.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        abort_if(!auth()->user()->can('create-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project = Project::create($request->safe()->only('project_name','project_status','is_public'));
        $project_details = [];
        $input = $request->validated();
        foreach (Project::ADDITIONAL_DETAILS as $key => $value) {
            array_push($project_details, ['project_keyname' => $key, 'project_keytype' => $value['type'], 'project_keyvalue' => $input[$key]]);
        }
        // dd($project_details);
        $project->projectDetails()->createMany($project_details);

        toast(__('global.crud_actions', ['module' => 'Project', 'action' => 'created']), 'success');
        return redirect()->route('dms.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        abort_if(!auth()->user()->can('show-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->load('projectDetails');

        return view('dms.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        abort_if(!auth()->user()->can('update-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $project->load('projectDetails');
        // dd($project);
        return view('dms.projects.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        abort_if(!auth()->user()->can('update-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->update($request->safe()->only('project_name','project_status','is_public'));
        $project_details = [];
        $input = $request->validated();
        foreach (Project::ADDITIONAL_DETAILS as $key => $value) {
            array_push($project_details, ['project_keyname' => $key, 'project_keytype' => $value['type'], 'project_keyvalue' => $input[$key]]);
        }
        $project->projectDetails()->delete();
        $project->projectDetails()->createMany($project_details);

        toast(__('global.crud_actions', ['module' => 'Project', 'action' => 'updated']), 'success');
        return redirect()->route('dms.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        abort_if(!auth()->user()->can('delete-project'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Project', 'action' => 'deleted']), 'success');
        return back();
    }
}
