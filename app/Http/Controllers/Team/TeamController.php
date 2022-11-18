<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\TeamRequest;
use App\Models\Org;
use App\Models\Team;
use App\Services\OrgService;
use App\Services\TeamService;
use Exception;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = TeamService::getTeamByOrgId($request,1);
        // dd($teams);

        return view('team.index',compact('teams'));
        // return "hI";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $org= OrgService::getOrg($request,['id','name']);
        $users = OrgService::getUser(1);
        $users= $users->users;
        return view('team.create',compact('org','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        // dd($request->all());
        try{
            TeamService::storeTeam($request);
            return back()->with('success','Team created successfully');
        }catch(Exception $e){
            return $e->getMessage();
        }
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
    public function edit(Request $request,$id)
    {
        $teamuserId = [];
        $team = Team::findOrFail($id);
        $org= OrgService::getOrg($request,['id','name']);
        $users = OrgService::getUser(1);
        $users= $users->users;
        // dd($team->teamUser);
        foreach($team->teamUser as $t){
            array_push($teamuserId,$t->id);
        }
        // dd($teamuserId);
        return view('team.edit',compact('team','org','users','teamuserId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request, $id)
    {
        try{
            TeamService::updateTeam($request,$id);
            return back()->with('success','Team Updated Successfully');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * team users
     */

     public function TeamUsers($id){
        $users = Team::find($id);
        $users = $users->teamUser;
        // dd($users);
        return view('team.team-users.index',compact('users'));
     }
}
