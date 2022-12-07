<?php

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\MassDestroyTeamRequest;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Org;
use App\Models\Team;
use Exception;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

        $inputSearchString = $request->input('s', '');

        $teams = Team::with('org:id,name')
            ->where('teams.org_id', auth()->user()->org_id)
            ->when(!empty($inputSearchString), function ($query) use ($inputSearchString) {
                $query->where(function ($query) use ($inputSearchString) {
                    $query->orWhere('team_name', 'LIKE', '%' . $inputSearchString . '%');
                    $query->orWhere(function ($query) use ($inputSearchString) {
                        $query->whereHas('org', function (Builder $builder) use ($inputSearchString) {
                            $builder->where('name', 'LIKE', '%' . $inputSearchString . '%');
                        });
                    });
                });
            })
            ->isActive()
            ->orderBy('id', 'DESC')
            ->paginate(config('app-config.per_page'));

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $org = Org::query()
            ->select('id','name')
            ->isActive()
            ->orderBy('id', 'DESC')
            ->get();

        $orgUsers = Org::query()
            ->with('users:id,org_id,name')
            ->where('id', auth()->user()->org_id)
            ->isActive()
            ->first();

        return view('teams.create', compact('org', 'orgUsers'));
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

        try {
            $team = Team::create($request->safe()->except('user_id'));
            $team->teamUser()->attach($request->user_id, $request->only('valid_from', 'valid_to'));

            return back()->with('success', 'Team created successfully');
        } catch (Exception $e) {

            abort(403, $e->getMessage());
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
    public function edit(Team $team)
    {
        abort_if(!auth()->user()->can('update-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $org = Org::query()
                ->select('name', 'id')
                ->isActive()
                ->orderBy('id', 'DESC')
                ->get();

            $orgUsers = Org::with('users:id,org_id,name')
                ->where('id', auth()->user()->org_id)
                ->isActive()
                ->first();

            $teamuserId = collect($team->teamUser)->pluck('id')->toArray();

            return view('teams.edit', compact('team', 'org', 'orgUsers', 'teamuserId'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        abort_if(!auth()->user()->can('update-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            $team->update($request->safe()->except('user_id'));
            $team->teamUser()->sync($request->user_id, $request->only('valid_from', 'valid_to'));

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
    public function destroy(Team $team)
    {
        abort_if(!auth()->user()->can('delete-team'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team->update([
            'is_active' => 3
        ]);

        return back()->with('success', 'Team deleted successfully');
    }

    public function massDestroy(MassDestroyTeamRequest $request)
    {
        Team::whereIn('id', $request->input('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->user()->id,
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
