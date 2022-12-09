<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Http\Requests\Process\MassDestroyProcessRequest;
use App\Http\Requests\Process\StoreProcessRequest;
use App\Http\Requests\Process\UpdateProcessRequest;
use App\Models\Org;
use App\Models\Process\Process;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $process = Process::query()
            ->select('id', 'process_name', 'total_duration', 'valid_from', 'valid_to', 'status')
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('process_name', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->isActive()
            ->orderBy('id', 'DESC')
            ->paginate(config('app-config.per_page'))
            ->withQueryString();

        return view('process.index', compact('process'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('id', 'DESC')
            ->get();

        return view('process.create', compact('org'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProcessRequest $request)
    {
        abort_if(!auth()->user()->can('create-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process = Process::create($request->safe()->only('process_name', 'process_description', 'total_duration', 'valid_from', 'valid_to', 'status', 'org_id','process_priority'));
        $process_details = [];
        $input = $request->validated();
        foreach (Process::ADDITIONAL_DETAILS as $key => $value) {
            array_push($process_details, ['process_key_name' => $key, 'process_key_type' => $value['type'], 'process_key_value' => $input[$key]]);
        }
        $process->processDetails()->createMany($process_details);

        if($request->hasFile('attachments')){
            $process->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachments');
            });
        }

        toast(__('global.crud_actions', ['module' => 'Process', 'action' => 'created']), 'success');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        abort_if(!auth()->user()->can('show-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->load('processDetails');
        $process->load('media');

        return view('process.show', compact('process'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Process $process)
    {
        abort_if(!auth()->user()->can('update-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('name', 'id')
            ->isActive()
            ->orderBy('id', 'DESC')
            ->get();

        $process->load('processDetails');

        return view('process.edit', compact('process', 'org'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProcessRequest $request, Process $process)
    {
        abort_if(!auth()->user()->can('update-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->update($request->safe()->only('process_name', 'process_description', 'total_duration', 'valid_from', 'valid_to', 'status', 'org_id','process_priority'));

        if($request->hasFile('attachments')){
            $process->media()->delete();
            $process->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachments');
            });
        }

        $input = $request->validated();
        $process_details = [];
        foreach (Process::ADDITIONAL_DETAILS as $key => $value) {
            array_push($process_details, ['process_key_name' => $key, 'process_key_type' => $value['type'], 'process_key_value' => $input[$key]]);
        }
        $process->processDetails()->delete();
        $process->processDetails()->createMany($process_details);

        toast(__('global.crud_actions', ['module' => 'Process', 'action' => 'updated']), 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        abort_if(!auth()->user()->can('delete-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Process', 'action' => 'deleted']), 'success');
        return back();
    }

    /**
     * remove the multiple resouce
     *
     */
    public function massDestroy(MassDestroyProcessRequest $request)
    {
        Process::whereIn('id', $request->input('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->user()->id,
            ]);

        toast(__('global.crud_actions', ['module' => 'Processes', 'action' => 'deleted']), 'success');
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
