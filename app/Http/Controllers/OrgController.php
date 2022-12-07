<?php

namespace App\Http\Controllers;
use App\Models\Org;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrgRequest;
use App\Http\Requests\MassDestroyOrgRequest;
use App\Http\Requests\UpdateOrgRequest;
class OrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-org'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $orgs = Org::with('media')->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        return view('orgs.index', [
            'orgs' => $orgs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-org'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('orgs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrgRequest $request)
    {
        $org = Org::create($request->safe()->only('name', 'plan_id', 'address', 'is_premium'));

        if($request->hasFile('attachments')){
            $org->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachments');
            });
        }
        toast(__('global.crud_actions', ['module' => 'Org', 'action' => 'created']), 'success');

        return redirect()->route('admin.orgs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Org $org)
    {
        abort_if(!auth()->user()->can('show-org'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('orgs.show', compact('org'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Org $org)
    {
        return view('orgs.edit', compact('org'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrgRequest $request, Org $org)
    {
        $org->update($request->safe()->only(['name','plan_id', 'address', 'is_premium']));

        if($request->hasFile('attachments')){
            $org->media()->delete();
            $org->addMultipleMediaFromRequest(['attachments'])
            ->each(function($attachment){
                $attachment->toMediaCollection('attachments');
            });
        }
        toast(__('global.crud_actions', ['module' => 'Org', 'action' => 'updated']), 'success');

        return redirect()->route('admin.orgs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Org $org)
    {
        abort_if(!auth()->user()->can('delete-org'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org->update([
            'is_active' => 3
        ]);
        toast(__('global.crud_actions', ['module' => 'Org', 'action' => 'deleted']), 'success');

        return back();
    }
    public function massDestroy(MassDestroyOrgRequest $request)
    {
        Org::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
