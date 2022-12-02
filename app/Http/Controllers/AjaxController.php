<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dept;
use App\Models\Process\Step;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    public function deptsByOrgId($org_id)
    {
        abort_if(!auth()->user()->can('read-department'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $depts = Dept::query()
            ->select('id', 'name')
            ->where('org_id', $org_id)
            ->orderBy('name')
            ->get();

        return response()->json($depts);
    }

    public function teamsByOrgId($org_id)
    {
        abort_if(!auth()->user()->can('read-teams'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $teams = Team::query()
            ->select('id', 'team_name as name')
            ->where('org_id', $org_id)
            ->orderBy('team_name')
            ->get();

        return response()->json($teams);
    }

    public function processByTeamId($team_id)
    {
        abort_if(!auth()->user()->can('read-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team = Team::find($team_id);
        $team->load('teamProcess');

        return response()->json($team);
    }

    public function stepByProcessId($process_id){
        $step = Step::query()
            ->select('id','name')
            ->where('process_id',$process_id)
            ->orderBy('name')
            ->get();

        return response()->json($step);
    }


    public function fetchUsersByOrgId($org_id)
    {
        abort_if(!auth()->user()->can('read-user'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::query()
            ->select('id', 'name')
            ->where('org_id', $org_id)
            ->isActive()
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }
}
