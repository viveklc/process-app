<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Models\Activity\ProcessInstance;
use App\Models\Activity\StepInstance;
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
        return view('process.instances.steps.index', compact('stepInstances', 'id'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!auth()->user()->can('show-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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

        // return view('process.instances.steps.edit',compact())
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('udpate-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StepInstance $stepInstance)
    {
        abort_if(!auth()->user()->can('delete-step-instance'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
}
