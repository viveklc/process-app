<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setp\MassDestroyStepRequest;
use App\Http\Requests\Setp\StoreStepRequest;
use App\Http\Requests\Setp\UpdateStepRequest;
use App\Models\Dept;
use App\Models\Process\Process;
use App\Models\Process\Step;
use App\Models\Team;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcessStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Process $process)
    {
        abort_if(!auth()->user()->can('read-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $processId = $process->id;
        $steps = $process->steps()
            ->with('org:id,name')
            ->with('team:id,team_name')
            ->with('dept:id,name')
            ->with('process:id,process_name')
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere(function($query) use ($inputSearchString){
                        $query->whereHas('org', function (Builder $builder) use ($inputSearchString) {
                            $builder->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                        });
                        $query->whereHas('team', function (Builder $builder) use ($inputSearchString) {
                            $builder->orWhere('teams.team_name', 'LIKE', '%' . $inputSearchString . '%');
                        });
                        $query->whereHas('dept', function (Builder $builder) use ($inputSearchString) {
                            $builder->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                        });
                        $query->whereHas('process', function (Builder $builder) use ($inputSearchString) {
                            $builder->orWhere('process_name', 'LIKE', '%' . $inputSearchString . '%');
                        });
                    });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.per_page'))
            ->withQueryString();

        return view('process.steps.index', compact('steps', 'processId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Process $process)
    {
        abort_if(!auth()->user()->can('create-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->load('steps');
        $depts = Dept::query()
            ->select('id', 'name')
            ->where('org_id', auth()->user()->org_id)
            ->isActive()
            ->orderBy('name')
            ->get();
        $teams = Team::query()
            ->select('id', 'team_name as name')
            ->where('org_id', auth()->user()->org_id)
            ->isActive()
            ->orderBy('team_name')
            ->get();

        return view('process.steps.create', compact('process','depts','teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStepRequest $request,Process $process)
    {
        abort_if(!auth()->user()->can('create-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step = $process->steps()->create($request->safe()->except('attachments'));

        if($request->hasFile('attachments')){
            $step->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachment');
            });
        }

        toast(__('global.crud_actions', ['module' => 'Step', 'action' => 'created']), 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process,Step $step)
    {
        abort_if(!auth()->user()->can('show-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step->load('process:id,process_name');
        $step->load('team:id,team_name');
        $step->load('org:id,name');
        $step->load('dept:id,name');
        $step->load('afterStep:id,name');
        $step->load('beforeStep:id,name');
        $step->load('media');

        return view('process.steps.show',compact('step','process'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process, Step $step)
    {
        abort_if(!auth()->user()->can('update-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->load('steps');
        $depts = Dept::query()
            ->select('id', 'name')
            ->where('org_id', auth()->user()->org_id)
            ->isActive()
            ->orderBy('name')
            ->get();
        $teams = Team::query()
            ->select('id', 'team_name as name')
            ->where('org_id', auth()->user()->org_id)
            ->isActive()
            ->orderBy('team_name')
            ->get();

        return view('process.steps.edit',compact('step','process','depts','teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStepRequest $request, Process $process, Step $step)
    {
        abort_if(!auth()->user()->can('update-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step->update($request->safe()->except('attachments'));

        if($request->hasFile('attachments')){
            $step->media()->delete();
            $step->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachment');
            });
        }

        toast(__('global.crud_actions', ['module' => 'Step', 'action' => 'updated']), 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process, Step $step)
    {
        abort_if(!auth()->user()->can('delete-step'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $step->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Step', 'action' => 'deleted']), 'success');
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

        toast(__('global.crud_actions', ['module' => 'Step', 'action' => 'deleted']), 'success');
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
