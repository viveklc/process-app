<?php

namespace App\Http\Controllers;
use App\Models\Admin\ClassModel;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyClassRequest;
use App\Models\Admin\Country;
use Symfony\Component\HttpFoundation\Response;
use Alert;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $classes = collect([]);

        $classes = ClassModel::select('id','name')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();



        return view('classes.index', [
            'classes' => $classes,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('classes.create');
    }

    public function store(StoreClassRequest $request)
    {
        ClassModel::create($request->validated());

        toast(__('global.crud_actions', ['module' => 'Class', 'action' => 'created']), 'success');
        return redirect()->route('admin.classes.index');
    }

    public function show(ClassModel $class)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('classes.show', compact('class'));
    }

    public function edit(ClassModel $class)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('classes.edit', compact('class'));
    }

    public function update(UpdateClassRequest $request, ClassModel $class)
    {

        $class->update([
            'name' => $request->name,
        ]);

        toast(__('global.crud_actions', ['module' => 'Class', 'action' => 'updated']), 'success');
        return redirect()->route('admin.classes.index');
    }

    public function destroy(ClassModel $class)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $class->delete();

        toast(__('global.crud_actions', ['module' => 'Class', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyClassRequest $request)
    {
        ClassModel::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
