<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\Admin\City;
use App\Models\Admin\State;
use Illuminate\Http\Request;
use App\Models\Admin\Country;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Requests\MassDestroyCityRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CityController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('All', 'all');

        $states = State::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('All', 'all');

        $inputSearchString = $request->input('s', '');
        $inputCountry = $request->input('country', '');
        $inputState   = $request->input('state', '');

        $selectedCountries = [];
        $selectedStates = [];
        $cities = collect([]);
        if(filled($inputSearchString) || filled($inputCountry)) {
            $selectedCountries = $inputCountry ? explode(',', $inputCountry) : [];
            $selectedStates = $inputState ? explode(',', $inputState) : [];

            $cities = City::select('id','name', 'country_id', 'country_name', 'state_id', 'state_name');

            if(!in_array('all', $selectedCountries)) {
                $cities = $cities->whereIn('country_id', $selectedCountries);

                if(filled($inputState) && !in_array('all', $selectedStates)) {
                    $cities = $cities->whereIn('state_id', $selectedStates);
                }
            }
                // ->when($selectedCountries, function($query) use ($selectedCountries, $selectedStates) {
                //     if(!in_array('all', $selectedCountries) || !in_array(999999, $selectedCountries)) {
                //         $query->whereIn('country_id', $selectedCountries);
                //     }
                // })
            $cities =  $cities->when($inputSearchString, function($query) use ($inputSearchString) {
                    $query->where(function($query) use ($inputSearchString) {
                        $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%')
                            ->orWhere('country_name', 'LIKE', '%'.$inputSearchString.'%')
                            ->orWhere('state_name', 'LIKE', '%'.$inputSearchString.'%');
                    });
                })
                ->isActive()
                ->orderBy('name')
                ->paginate(config('app-config.datatable_default_row_count', 25))
                ->withQueryString();
        }

        return view('cities.index', [
            'cities' => $cities,
            'countries' => $countries,
            'selectedCountries' => $selectedCountries,
            'states' => $states,
            'selectedStates' => $selectedStates
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('create-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        return view('cities.create', compact('countries'));
    }

    public function store(StoreCityRequest $request)
    {
        $countryName = Country::find($request->country_id, ['name']);
        $stateName = State::find($request->state_id, ['name']);

        $city = City::create([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'country_name' => $countryName->name ?? '',
            'state_id' => $request->state_id,
            'state_name' => $stateName->name ?? ''
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $city->addMedia($request->file('image'))->toMediaCollection('City');
        }

        toast(__('global.crud_actions', ['module' => 'City', 'action' => 'created']), 'success');
        return redirect()->route('admin.cities.index');
    }

    public function show(City $city)
    {
        abort_if(!auth()->user()->can('show-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        abort_if(!auth()->user()->can('update-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        $states = $city->select('state_id', 'state_name')
            ->isActive()
            ->orderBy('state_name')
            ->pluck('state_name', 'state_id')
            ->prepend('Please select', '');

        return view('cities.edit', compact('city', 'countries', 'states'));
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $countryName = Country::find($request->country_id, ['name']);
        $stateName = State::find($request->state_id, ['name']);

        $city->update([
            'name' => $request->name,
            'country_id' => $request->country_id,
            'country_name' => $countryName->name ?? '',
            'state_id' => $request->state_id,
            'state_name' => $stateName->name ?? ''
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $city->addMedia($request->file('image'))->toMediaCollection('City');
        }

        toast(__('global.crud_actions', ['module' => 'City', 'action' => 'updated']), 'success');
        return redirect()->route('admin.cities.index');
    }

    public function destroy(City $city)
    {
        abort_if(!auth()->user()->can('delete-city'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city->delete();

        toast(__('global.crud_actions', ['module' => 'City', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyCityRequest $request)
    {
        City::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getStates(Request $request) {
        if($request->country_id) {
            $states = State::query();
            if($request->type && $request->type === 'array') {
                if(!in_array('all', $request->country_id))
                $states = $states->whereIn('country_id', $request->country_id);
            }
            else {
                $states = $states->where('country_id', $request->country_id);
            }
            $states = $states->isActive()->get();
            $response = array();
            if($states->count()) {
                foreach($states as $state){
                    $response[] = array(
                        "id"=>$state->id,
                        "text"=>$state->name
                    );
                }
            }
            return response()->json($response);
        }
        else {
            return response()->json([]);
        }
    }
}
