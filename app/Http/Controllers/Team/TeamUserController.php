<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Team;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Team\AddUserToTeamRequest;
use App\Http\Requests\Team\MassRemoveUserFromTeamRequest;

class TeamUserController extends Controller
{
    public function index(Request $request, Team $team)
    {
        abort_if(!auth()->user()->can('read-team-users'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = $team->id;
        $inputSearchString = $request->input('s', '');
        $teamUsers = $team->teamUser;

        return view('teams.team-users.index', compact('teamUsers', 'id'));
    }

    public function create(Team $team)
    {
        abort_if(!auth()->user()->can('add-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addTouser = User::whereNotIn('id', collect($team->teamUser)->pluck('id')->toArray())
            ->select('id', 'name')
            ->get();

        return view('teams.team-users.add', ['addTouser' => $addTouser, 'id' => $team->id]);
    }



    public function store(AddUserToTeamRequest $request,Team $team)
    {
        abort_if(!auth()->user()->can('add-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team = Team::find($request->team_id);
        $team->teamUser()->attach($request->user_id);

        return redirect()->route('admin.team.user.index', $team->id)->with('success', 'User added to team');
    }

    public function destroy(Team $team, $user_id)
    {
        // dd($team);
        abort_if(!auth()->user()->can('delete-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->teamUser()->detach($user_id);

        return back()->with('success', 'User deleted successfully');
    }

    public function removeUsersFromTeam(MassRemoveUserFromTeamRequest $request)
    {
        abort_if(!auth()->user()->can('delete-team-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team = Team::find($request->team_id);
        $team->teamUser()->detach($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
