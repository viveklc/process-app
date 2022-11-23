<?php
namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamService
{

    public static function getTeamByOrgId(Request $request,int $orgId,array $field=[]){
        $select = count($field) > 0 ? implode($field) : "*";
        return Team::WithFilter($request)
        ->where('org_id',$orgId)->orderBy('id','DESC')
        ->select($select,DB::raw("(select name from orgs where id=teams.org_id limit 1) as org_name"))
        ->isActive()
        ->paginate(config('app-config.per_page'));
    }


    public static function storeTeam(Request $request){
        $team = Team::create([
            'org_id' => $request->input('org_id'),
            'team_name' => $request->input('team_name'),
            'team_remarks' => $request->input('team_remarks'),
            'team_description' => $request->input('team_description'),
            'valid_from' => $request->input('valid_from'),
            'valid_to' => $request->input('valid_to'),
        ]);
        $team->teamUser()->attach($request->user_id,[
            'valid_from' => $request->input('valid_from'),
            'valid_to' => $request->input('valid_to'),
        ]);

        return $team;
    }


    public static function updateTeam(Request $request,$id){
        $team = Team::find($id);
        $team->update([
            'org_id' => $request->input('org_id'),
            'team_name' => $request->input('team_name'),
            'team_remarks' => $request->input('team_remarks'),
            'team_description' => $request->input('team_description'),
            'valid_from' => $request->input('valid_from'),
            'valid_to' => $request->input('valid_to'),
        ]);
        $team->teamUser()->sync($request->user_id,[
            'valid_from' => $request->input('valid_from'),
            'valid_to' => $request->input('valid_to'),
        ]);

        return $team;
    }





}
