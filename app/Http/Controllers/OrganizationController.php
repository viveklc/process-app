<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrganizationRequest;
use App\Http\Requests\UpdateOrganizationRequest;
use App\Http\Requests\MassDestroyOrganizationRequest;
use App\Models\Admin\City;
use App\Models\Admin\Country;
use App\Models\Admin\State;
use App\Models\Admin\Organization;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-organization'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countryIds = $request->input('country', '');
        $stateIds = $request->input('state', '');
        $cityIds = $request->input('city', '');

        $inputSearchString = $request->input('s', '');
        $organizations = Organization::with('country','state','city')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%');
                })
                ->WhereHas('country', function ($query)use($inputSearchString) {
                    $query->where('name', 'Like', '%' . $inputSearchString . '%');
                })
                ->orWhereHas('state', function ($query)use($inputSearchString) {
                    $query->where('name', 'Like', '%' . $inputSearchString . '%');
                })
                ->orWhereHas('city', function ($query)use($inputSearchString) {
                    $query->where('name', 'Like', '%' . $inputSearchString . '%');
                });
            });

        $states = "";
        if(!empty($countryIds)) {
            $organizations = $organizations->whereIn('country_id', $countryIds);
            $states = State::isActive()
                ->where('country_id',$countryIds)
                ->get();
        }

        $cities = "";
        if(!empty($stateIds)) {
            $organizations = $organizations->whereIn('state_id', $stateIds);
            $cities = City::isActive()
                ->where('state_id',$stateIds)
                ->get();
        }

        if(!empty($cityIds)) {
            $organizations = $organizations->whereIn('city_id', $cityIds);
        }

        $organizations = $organizations->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        $countries = Country::isActive()
            ->get();
        return view('organizations.index', [
            'organizations' => $organizations,
            'countries' => $countries,
            'countryIds' => $countryIds,
            'stateIds' => $stateIds,
            'cityIds' => $cityIds,
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('create-organization'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::isActive()
            ->get();
        $states = State::isActive()
            ->get();
        $cities = City::isActive()
            ->get();
        return view('organizations.create', compact('countries','states','cities'));
    }

    public function store(StoreOrganizationRequest $request)
    {
        $organization = Organization::create($request->except('organization_image_url'));

        if($request->hasFile('organization_image_url') && $request->file('organization_image_url')->isValid()) {
            $organization->addMedia($request->file('organization_image_url'))->toMediaCollection('Organization');
        }

        toast(__('global.crud_actions', ['module' => 'Organization', 'action' => 'created']), 'success');
        return redirect()->route('admin.organizations.index');
    }

    public function show(Organization $organization)
    {
        abort_if(!auth()->user()->can('show-organization'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('organizations.show', compact('organization'));
    }

    public function edit(Organization $organization)
    {
        abort_if(!auth()->user()->can('update-organization'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::isActive()
            ->get();
        $states = State::isActive()
            ->where('country_id',$organization->country_id)
            ->get();
        $cities = City::isActive()
            ->where('state_id',$organization->state_id)
            ->get();

        return view('organizations.edit', compact('organization', 'countries', 'states', 'cities'));
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->except('organization_image_url'));

        if($request->hasFile('organization_image_url') && $request->file('organization_image_url')->isValid()) {
            $organization->addMedia($request->file('organization_image_url'))->toMediaCollection('Organization');
        }

        toast(__('global.crud_actions', ['module' => 'Organization', 'action' => 'updated']), 'success');
        return redirect()->route('admin.organizations.index');
    }

    public function destroy(Organization $organization)
    {
        abort_if(!auth()->user()->can('delete-organization'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organization->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Organization', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyOrganizationRequest $request)
    {
        Organization::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }
}
