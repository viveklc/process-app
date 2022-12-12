<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\instances\step\MassDestroyStepInstaceRequest;
use App\Http\Requests\Process\instances\step\UpdateStepInstaceRequest;
use App\Models\Activity\ProcessInstance;
use App\Models\Activity\StepInstance;
use App\Models\Process\Step;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StepInstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProcessInstance $processInstance)
    {
        abort_if(!auth()->user()->can('read-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $id = $processInstance->id;
        $processId = $processInstance->process_id;
        $stepInstances = $processInstance->stepInstances()
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.per_page'));
            // dd($stepInstances);
        return view('process.instances.steps.index', compact('stepInstances', 'id','processId'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessInstance $processInstance, StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('show-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stepInstance->load('process:id,process_name');
        $stepInstance->load('team:id,team_name');
        $stepInstance->load('org:id,name');
        $stepInstance->load('dept:id,name');
        $stepInstance->load('afterStep:id,name');
        $stepInstance->load('beforeStep:id,name');
        $stepInstance->load('media');
        // dd($stepInstance);
        return view('process.instances.steps.show',compact('stepInstance','processInstance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessInstance $processInstance, StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('update-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $processInstanceId = $processInstance->id;
        $processSteps = StepInstance::query()
            ->select('name', 'id')
            ->where('process_id',$stepInstance->process_id)
            ->isActive()
            ->orderBy('name')
            ->get();

        return view('process.instances.steps.edit',compact('stepInstance','processSteps','processInstanceId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStepInstaceRequest $request, ProcessInstance $processInstance , StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('update-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stepInstance->update($request->validated());

        toast(__('global.crud_actions', ['module' => 'Step instance', 'action' => 'updated']), 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessInstance $processInstance,StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('delete-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stepInstance->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Step instance', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyStepInstaceRequest $request)
    {
        abort_if(!auth()->user()->can('delete-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        StepInstance::whereIn('id',$request->ids)
        ->update([
            'is_active' => 3,
            'updatedby_userid' => auth()->user()->id,
        ]);

        toast(__('global.crud_actions', ['module' => 'Step instance', 'action' => 'deleted']), 'success');
        return response(null, Response::HTTP_NO_CONTENT);

    }
}
