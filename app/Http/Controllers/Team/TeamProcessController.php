<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\MassDestroyTeamProcessRequest;
use App\Http\Requests\Team\StoreTeamProcessRequest;
use App\Models\Process\Process;
use App\Models\Team;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Team $team)
    {
        abort_if(!auth()->user()->can('read-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');

        $id = $team->id;
        $teamProcess = $team->teamProcess()
            ->when($inputSearchString, function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('process_name', 'LIKE', '%' . $inputSearchString . '%');
                });
            })
            ->paginate(10);


        return view('teams.team-process.index', compact('teamProcess', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Team $team)
    {
        abort_if(!auth()->user()->can('create-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team_id = $team->id;
        $process = Process::whereNotIn('id', collect($team->teamProcess)->pluck('id')->toArray())
        ->select('id', 'process_name')
        ->isActive()
        ->get();

        return view('teams.team-process.add',compact('process','team_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamProcessRequest $request,Team $team)
    {
        abort_if(!auth()->user()->can('create-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->teamProcess()->attach($request->process_id,$request->safe()->only('valid_from','valid_to'));

        return back()->with('success','Process assigned successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team,$process_id)
    {
        abort_if(!auth()->user()->can('delete-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->teamProcess()->detach($process_id);

        return back()->with('success', 'process deleted successfully');
    }

    public function massDestroy(MassDestroyTeamProcessRequest $request)
    {
        abort_if(!auth()->user()->can('delete-team-process'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $process = Team::find($request->team_id);
        $process->teamProcess()->detach($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
