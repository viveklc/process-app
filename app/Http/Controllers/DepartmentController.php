<?php

namespace App\Http\Controllers;
use Alert;
use Illuminate\Http\Request;
use App\Models\Content\Detail;
use App\Models\Admin\Department;
use App\Models\Admin\Organization;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyDepartmentRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $departments = collect([]);

        $departments = Department::select('id', 'name', 'description', 'organization_id')
            ->with('organization:id,name')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('organization', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();



        return view('departments.index', [
            'departments' => $departments,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = Organization::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        return view('departments.create', compact('organizations'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create([
            'name' => $request->name,
            'organization_id' => $request->organization_id,
            'description' => $request->description,
        ]);

        $input = $request->validated();

        foreach(Department::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $department->id,
                'sourceable_type' => get_class($department),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Department', 'action' => 'created']), 'success');
        return redirect()->route('admin.departments.index');
    }

    public function show(Department $department)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizations = Organization::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        $additionalDetails = Detail::where([
            'sourceable_id' => $department->id,
            'sourceable_type' => get_class($department),
        ])
        ->isActive()
        ->get()->pluck('detail_keyvalue');

        return view('departments.edit', compact('department', 'organizations', 'additionalDetails'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update([
            'name' => $request->name,
            'organization_id' => $request->organization_id,
            'description' => $request->description,
        ]);

        $input = $request->validated();

        foreach(Department::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $department->id,
                'sourceable_type' => get_class($department),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Department', 'action' => 'updated']), 'success');
        return redirect()->route('admin.departments.index');
    }

    public function destroy(Department $department)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department->delete();

        toast(__('global.crud_actions', ['module' => 'Department', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyDepartmentRequest $request)
    {
        Department::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
