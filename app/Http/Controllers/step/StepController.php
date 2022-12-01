<?php

namespace App\Http\Controllers\step;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setp\MassDestroyStepRequest;
use App\Http\Requests\Setp\StoreStepRequest;
use App\Http\Requests\Setp\UpdateStepRequest;
use App\Models\Dept;
use App\Models\Org;
use App\Models\Process\Process;
use App\Models\Process\Step;
use App\Models\Team;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Symfony\Component\HttpFoundation\Response;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $steps = Step::query()
            ->with('org:id,name')
            ->with('team:id,team_name')
            ->with('dept:id,name')
            ->with('process:id,process_name')
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->whereHas('org', function (Builder $builder) use ($inputSearchString) {
                        $builder->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                    $query->whereHas('team', function (Builder $builder) use ($inputSearchString) {
                        $builder->orWhere('team_name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                    $query->whereHas('dept', function (Builder $builder) use ($inputSearchString) {
                        $builder->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                    $query->whereHas('process', function (Builder $builder) use ($inputSearchString) {
                        $builder->orWhere('process_name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.per_page'));

        return view('steps.index', compact('steps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('name')
            ->get();

        $steps = Step::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('name')
            ->get();

        return view('steps.create', compact('org', 'steps'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStepRequest $request)
    {
        abort_if(!auth()->user()->can('create-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validated = $request->merge(
            [
                'is_substep' => isset($request->is_substep) ? 1 : 2,
                'is_conditional' => isset($request->is_conditional) ? 1 : 2,
                'is_mandatory' => isset($request->is_mandatory) ? 1 : 2
            ]
        );

        $step = Step::create($validated->all());

        if ($request->hasFile('has_attachments')) {
            // $step->addMediaFromRequest('has_attachments')->toMediaCollection('has_attachments');
            $step->addMultipleMediaFromRequest(['has_attachments'])
            ->each(function(FileAdder $fileAdder){
                $fileAdder->toMediaCollection('has_attachment');
            });
        }

        return back()->with('success', 'Step created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Step $step)
    {
        abort_if(!auth()->user()->can('show-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step->load('process:id,process_name');
        $step->load('team:id,team_name');
        $step->load('org:id,name');
        $step->load('dept:id,name');

        return view('steps.show',compact('step'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Step $step)
    {
        abort_if(!auth()->user()->can('update-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('name')
            ->get();

        $depts = Dept::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('name')
            ->get();

        $teams = Team::query()
            ->select('team_name as name', 'id')
            ->isActive()
            ->orderBy('team_name')
            ->get();

        $process = Process::query()
            ->select('process_name as name', 'id')
            ->isActive()
            ->orderBy('process_name')
            ->get();

        $steps = Step::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('name')
            ->get();

        return view('steps.edit', compact('org', 'depts', 'teams', 'process', 'steps', 'step'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStepRequest $request, Step $step)
    {
        abort_if(!auth()->user()->can('update-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validated = $request->merge(
            [
                'is_substep' => isset($request->is_substep) ? 1 : 2,
                'is_conditional' => isset($request->is_conditional) ? 1 : 2,
                'is_mandatory' => isset($request->is_mandatory) ? 1 : 2
            ]
        );

        $step->update($validated->all());

        if ($request->hasFile('has_attachments') && $request->file('has_attachments')->isValid()) {
            $step->addMediaFromRequest('has_attachments')->toMediaCollection('has_attachments');
        }

        return back()->with('success', 'Step udpated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Step $step)
    {
        abort_if(!auth()->user()->can('delete-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step->update([
            'is_active' => 3
        ]);

        return back()->with('success', 'Step deleted successfully');
    }

    public function massDestroy(MassDestroyStepRequest $request)
    {
        abort_if(!auth()->user()->can('delete-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Step::whereIn('id', $request->input('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->user()->id,
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
