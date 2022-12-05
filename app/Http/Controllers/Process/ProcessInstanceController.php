<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\instances\MassDestroyProcessInstanceRequest;
use App\Http\Requests\process\instances\StoreInstanceRequest;
use App\Http\Requests\process\instances\UpdateInstanceRequest;
use App\Models\Activity\ProcessInstance;
use App\Models\Activity\StepInstance;
use App\Models\Process\Process;
use App\Models\Process\Step;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcessInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Process $process)
    {
        abort_if(!auth()->user()->can('read-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $id = $process->id;
       $processInstance= $process->processInstances()
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('process_instance_name', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->get();

            // dd($processInstance);

        return view('process.instances.index', compact('processInstance','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Process $process)
    {
        abort_if(!auth()->user()->can('create-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users  = User::query()
            ->select('id','name')
            ->where('org_id',$process->org_id)
            ->isActive()
            ->orderBy('name')
            ->get();

        $team = Team::query()
        ->select('id','team_name as name')
        ->where('org_id',$process->org_id)
        ->isActive()
        ->orderBy('name')
        ->get();
        // dd($users);
        return view('process.instances.add',compact('users','process','team'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInstanceRequest $request, Process $process)
    {
        abort_if(!auth()->user()->can('create-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $request->merge([
            'org_id' => $process->org_id,
            'process_description' => $process->process_description,
            'process_priority' => $process->process_priority,
            'total_duration' => $process->total_duration
        ]);
        // dd($request->all());
       $instance= $process->processInstances()->create($request->all());
       $this->cloneStep($process->id,$instance->id,$instance->process_instance_name,$instance->assigned_to_user_id);

        return back()->with('success','Process instance created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process,ProcessInstance $processInstance)
    {
        abort_if(!auth()->user()->can('update-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users  = User::query()
            ->select('id','name')
            ->where('org_id',$process->org_id)
            ->isActive()
            ->orderBy('name')
            ->get();

        $team = Team::query()
        ->select('id','team_name as name')
        ->where('org_id',$process->org_id)
        ->isActive()
        ->orderBy('name')
        ->get();

        return view('process.instances.edit',compact('users','team','process','processInstance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstanceRequest $request, Process $process, ProcessInstance $processInstance)
    {
        abort_if(!auth()->user()->can('update-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $processInstance->update($request->validated());

        return back()->with('success','Instance updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process, $process_instances_id)
    {
        abort_if(!auth()->user()->can('delete-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->processInstances()->detach($process_instances_id);

        return back()->with('success', 'process deleted successfully');
    }

    public function massDestroy(MassDestroyProcessInstanceRequest $request)
    {
        abort_if(!auth()->user()->can('delete-process-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process = Process::find($request->process_id);
        $process->processInstances()->detach($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);

    }

    public function cloneStep(int $process_id,int $process_instances_id,string $process_instance_name,int $assigned_to_user_id){
       $steps = Step::query()
       ->with('process:id,process_name')
       ->with('team:id,team_name')
       ->with('org:id,name')
       ->with('dept:id,name')
        ->where('process_id',$process_id)
        ->orderBy('id')
        ->get();
        foreach($steps as $step)
        {
            StepInstance::create([
                'name' => $step->name,
                'description' => $step->description,
                'org_id' => $step->org_id,
                'org_name' => $step->org->name,
                'dept_id' => $step->dept_id,
                'dept_name' => $step->dept->name,
                'team_id' => $step->team_id,
                'team_name' => $step->team->team_name,
                'process_id' => $step->process_id,
                'process_name' => $step->process->process_name,
                'process_instances_id' => $process_instances_id,
                'process_instance_name' => $process_instance_name,
                'step_id' => $step->id,
                'step_name' => $step->name,
                'sequence' => $step->sequence,
                'before_step_instance_id' => $step->before_step_instance_id,
                'after_step_instance_id' => $step->after_step_instance_id,
                'is_substep' => $step->is_substep,
                'has_attachments' => $step->has_attachments,
                'has_comments' => 2,
                'is_mandatory' => $step->is_mandatory,
                'planned_total_duration' => $step->total_duration,
                'assigned_to_user_id' => $step->assigned_to_user_id,

            ]);
        }

        return true;
    }
}
