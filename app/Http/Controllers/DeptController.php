<?php

namespace App\Http\Controllers;

use App\Models\Dept;
use App\Models\Org;
use App\Http\Requests\StoreDeptRequest;
use App\Http\Requests\MassDestroyDeptRequest;
use App\Http\Requests\UpdateDeptRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DeptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $depts = Dept::query()
        ->with('org:id,name')
        ->when($inputSearchString, function ($query) use ($inputSearchString) {
            $query->where(function ($query) use ($inputSearchString) {
                $query->orWhere('name', 'LIKE', '%' . $inputSearchString . '%');
                $query->orWhere(function ($query) use ($inputSearchString) {
                    $query->whereHas('org', function (Builder $builder) use ($inputSearchString) {
                        $builder->where('name', 'LIKE', '%' . $inputSearchString . '%');
                    });
                });
            });
        })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        return view('depts.index', [
            'depts' => $depts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $orgs = Org::query()
            ->select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->get();

        return view('depts.create', compact('orgs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeptRequest $request)
    {
        abort_if(!auth()->user()->can('create-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->validated());
        $dept = Dept::create($request->safe()->only('org_id', 'name', 'description'));

        if ($request->hasFile('attachments')) {
            $dept->addMultipleMediaFromRequest(['attachments'])
                ->each(function ($attachment) {
                    $attachment->toMediaCollection('attachments');
                });
        }

        toast(__('global.crud_actions', ['module' => 'Dept', 'action' => 'created']), 'success');

        return redirect()->route('admin.depts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dept $dept)
    {
        abort_if(!auth()->user()->can('show-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dept->load('org:id,name');
        $dept->load('media');

        return view('depts.show', compact('dept'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dept $dept)
    {
        $orgs = Org::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        $dept->load('media');

        return view('depts.edit', compact('dept', 'orgs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeptRequest $request, Dept $dept)
    {
        $dept->update($request->safe()->only(['org_id', 'name', 'description']));

        if ($request->hasFile('attachments')) {

            $dept->addMultipleMediaFromRequest(['attachments'])
                ->each(function ($attachment) {
                    $attachment->toMediaCollection('attachments');
                });
        }

        toast(__('global.crud_actions', ['module' => 'Dept', 'action' => 'updated']), 'success');

        return redirect()->route('admin.depts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dept $dept)
    {
        abort_if(!auth()->user()->can('delete-dept'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dept->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Dept', 'action' => 'deleted']), 'success');

        return back();
    }
    public function massDestroy(MassDestroyDeptRequest $request)
    {
        Dept::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        toast(__('global.crud_actions', ['module' => 'Dept', 'action' => 'deleted']), 'success');

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
