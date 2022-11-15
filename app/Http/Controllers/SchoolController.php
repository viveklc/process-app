<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Http\Requests\MassDestroySchoolRequest;
use App\Models\Admin\City;
use App\Models\Admin\Country;
use App\Models\Admin\State;
use App\Models\Admin\School;
use Symfony\Component\HttpFoundation\Response;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        // abort_if(!auth()->user()->can('read-school'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $schools = School::with('country','state','city')
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
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();
        return view('schools.index', [
            'schools' => $schools,
        ]);
    }

    public function create()
    {
        // abort_if(!auth()->user()->can('create-school'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('schools.create', compact('countries','states','cities'));
    }

    public function store(StoreSchoolRequest $request)
    {
        $school = School::create($request->except('school_image_url'));

        if($request->hasFile('school_image_url') && $request->file('school_image_url')->isValid()) {
            $school->addMedia($request->file('school_image_url'))->toMediaCollection('School');
        }

        toast(__('global.crud_actions', ['module' => 'School', 'action' => 'created']), 'success');
        return redirect()->route('admin.schools.index');
    }

    public function show(School $school)
    {
        // abort_if(!auth()->user()->can('show-school'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        // abort_if(!auth()->user()->can('update-school'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $countries = Country::all();
        $states = State::all();
        $cities = City::all();

        return view('schools.edit', compact('school', 'countries', 'states', 'cities'));
    }

    public function update(UpdateSchoolRequest $request, School $school)
    {
        $school->update($request->except('school_image_url'));

        if($request->hasFile('school_image_url') && $request->file('school_image_url')->isValid()) {
            $school->addMedia($request->file('school_image_url'))->toMediaCollection('School');
        }

        toast(__('global.crud_actions', ['module' => 'School', 'action' => 'updated']), 'success');
        return redirect()->route('admin.schools.index');
    }

    public function destroy(School $school)
    {
        // abort_if(!auth()->user()->can('delete-school'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $school->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'School', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroySchoolRequest $request)
    {
        School::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
