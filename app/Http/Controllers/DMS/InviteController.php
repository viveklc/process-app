<?php

namespace App\Http\Controllers\DMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\DMS\StoreInviteRequest;
use App\Models\DMS\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InviteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Project $project)
    {
        abort_if(!auth()->user()->can('invite-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $project->id;
        $inputSearchString = $request->input('s', '');

        $projectInvites = $project->projectInvites()
        ->with('invitedBy:id,name')
        ->when($inputSearchString, function($query) use ($inputSearchString){
            $query->where(function($query) use ($inputSearchString){
                $query->orWhere('user_email','LIKE','%'.$inputSearchString.'%');
            });
        })
        ->where('invites.is_active',1)
        ->orderBy('created_at')
        ->paginate(config('app-config.per_page'))
        ->withQueryString();
        // dd($projectInvites);
        return view('dms.projects.invites.index',compact('projectInvites','id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        abort_if(!auth()->user()->can('invite-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $project->id;
        return view('dms.projects.invites.add',compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInviteRequest $request,Project $project)
    {
        abort_if(!auth()->user()->can('invite-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emailArray = explode(',',$request->user_email);

        foreach($emailArray as $useremail){
            $project->projectInvites()->create([
                'user_email' => $useremail,
                'invited_for_role' => $request->invited_for_role,
                'invited_by_user_id' => auth()->user()->id,
                'invite_status' => 1,
                'invite_valid_upto' => $request->invite_valid_upto
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Invite', 'action' => 'created']), 'success');
        return redirect()->route('dms.project.invites.index',$project->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!auth()->user()->can('show-invites'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!auth()->user()->can('delete-invites'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
}
