<?php

namespace App\Http\Controllers;
use App\Models\Admin\State;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyStateRequest;
use App\Models\Admin\Country;
use Symfony\Component\HttpFoundation\Response;
use Alert;
use App\Http\Requests\StoreStateRequest;
use App\Http\Requests\UpdateStateRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class StateController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $inputCountry = $request->input('country', '');

        $selectedCountries = [];
        $states = collect([]);

        $states = State::select('id','name','country_id', 'country_name')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%')
                          ->orWhere('country_name', 'LIKE', '%'.$inputSearchString.'%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();



        return view('states.index', [
            'states' => $states,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        return view('states.create', compact('countries'));
    }

    public function store(StoreStateRequest $request)
    {
        $countryName = Country::find( $request->country_id, ['name']);

        State::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'country_name' => $countryName->name ?? ''
        ]);

        toast(__('global.crud_actions', ['module' => 'State', 'action' => 'created']), 'success');
        return redirect()->route('admin.states.index');
    }

    public function show(State $state)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('states.show', compact('state'));
    }

    public function edit(State $state)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        return view('states.edit', compact('state', 'countries'));
    }

    public function update(UpdateStateRequest $request, State $state)
    {
        $countryName = Country::find( $request->country_id, ['name']);

        $state->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'country_name' => $countryName->name ?? ''
        ]);

        toast(__('global.crud_actions', ['module' => 'State', 'action' => 'updated']), 'success');
        return redirect()->route('admin.states.index');
    }

    public function destroy(State $state)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $state->delete();

        toast(__('global.crud_actions', ['module' => 'State', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyStateRequest $request)
    {
        State::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
