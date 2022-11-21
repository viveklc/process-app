<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\AddUserToTeamRequest;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Org;
use App\Models\Team;
use App\Models\User;
use App\Services\OrgService;
use App\Services\TeamService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-teams'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $teams = Team::WithFilter($request)
            ->where('org_id', 1)->orderBy('id', 'DESC')
            ->select("*", DB::raw("(select name from orgs where id=teams.org_id limit 1) as org_name"))
            ->isActive()
            ->paginate(config('app-config.per_page'));;
        // dd($teams);
        return view('teams.index', compact('teams'));
        // return "hI";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        abort_if(!auth()->user()->can('create-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $org = Org::orderBy('id', 'DESC')
            ->where('is_active', 1)
            ->select('name', 'id')
            ->isActive()
            ->get();
        $users = Org::with(['users'])
            ->where('id', 1)
            ->isActive()
            ->first();
        $users = $users->users;
        return view('teams.create', compact('org', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        abort_if(!auth()->user()->can('create-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($request->all());
        try {
            $team = Team::create([
                'org_id' => $request->input('org_id'),
                'team_name' => $request->input('team_name'),
                'team_remarks' => $request->input('team_remarks'),
                'team_description' => $request->input('team_description'),
                'valid_from' => $request->input('valid_from'),
                'valid_to' => $request->input('valid_to'),
            ]);
            $team->teamUser()->attach($request->user_id, [
                'valid_from' => $request->input('valid_from'),
                'valid_to' => $request->input('valid_to'),
            ]);
            return back()->with('success', 'Team created successfully');
        } catch (Exception $e) {
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
    public function edit(Request $request, $id)
    {
        abort_if(!auth()->user()->can('update-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $teamuserId = [];
        $team = Team::findOrFail($id);
        $org = OrgService::getOrg($request, ['id', 'name']);
        $users = OrgService::getUser(1);
        $users = $users->users;
        // dd($team->teamUser);
        foreach ($team->teamUser as $t) {
            array_push($teamuserId, $t->id);
        }
        // dd($teamuserId);
        return view('teams.edit', compact('team', 'org', 'users', 'teamuserId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, $id)
    {
        abort_if(!auth()->user()->can('update-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try {
            $team = Team::find($id);
            $team->update([
                'org_id' => $request->input('org_id'),
                'team_name' => $request->input('team_name'),
                'team_remarks' => $request->input('team_remarks'),
                'team_description' => $request->input('team_description'),
                'valid_from' => $request->input('valid_from'),
                'valid_to' => $request->input('valid_to'),
            ]);
            $team->teamUser()->sync($request->user_id, [
                'valid_from' => $request->input('valid_from'),
                'valid_to' => $request->input('valid_to'),
            ]);
            return back()->with('success', 'Team Updated Successfully');
        } catch (Exception $e) {
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
        abort_if(!auth()->user()->can('delete-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Team::find($id)->update([
            'is_active'=>3
        ]);
        return back()->with('success','Team deleted successfully');

        //
    }

    /**
     * team users
     */

    public function TeamUsers($id)
    {
        abort_if(!auth()->user()->can('read-team-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = Team::find($id);
        $users = $users->teamUser;
        $addTouser = User::whereNotIn('id',$this->getIdFromUser($users))
        ->select('id','name')
        ->get();

        return view('teams.team-users.index', compact('users','id','addTouser'));
    }

    public function addUserToTeam(AddUserToTeamRequest $request)
    {
        abort_if(!auth()->user()->can('add-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $team =Team::find($request->input('team_id'));
        $team->teamUser()->attach($request->input('user_id'));

        return back()->with('success','User added to team');
    }

    public function removeUserFromTeam($user_id)
    {
        abort_if(!auth()->user()->can('delete-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function getIdFromUser($users){
        $id=[];
        foreach($users as $user){
            array_push($id,$user->id);
        }
        return $id;
    }
}
