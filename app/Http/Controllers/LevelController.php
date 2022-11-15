<?php

namespace App\Http\Controllers;
use App\Models\Content\Level;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyLevelRequest;
use App\Models\Content\Course;
use Symfony\Component\HttpFoundation\Response;
use Alert;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Content\Detail;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $levels = collect([]);

        $levels = Level::select('id', 'name', 'short_description', 'long_description', 'course_id')
            ->with('course:id,name')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('course', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();



        return view('levels.index', [
            'levels' => $levels,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        return view('levels.create', compact('courses'));
    }

    public function store(StoreLevelRequest $request)
    {
        $level = Level::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $level->addMedia($request->file('image'))->toMediaCollection('Level');
        }

        $input = $request->validated();

        foreach(Level::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $level->id,
                'sourceable_type' => get_class($level),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Level', 'action' => 'created']), 'success');
        return redirect()->route('admin.levels.index');
    }

    public function show(Level $level)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('levels.show', compact('level'));
    }

    public function edit(Level $level)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::select('id', 'name')
            ->isActive()
            ->orderBy('name')
            ->pluck('name', 'id')
            ->prepend('Please select', '');

        $additionalDetails = Detail::where([
                'sourceable_id' => $level->id,
                'sourceable_type' => get_class($level),
            ])
            ->isActive()
            ->get()->pluck('detail_keyvalue');

        return view('levels.edit', compact('level', 'courses', 'additionalDetails'));
    }

    public function update(UpdateLevelRequest $request, Level $level)
    {
        $level->update([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $level->addMedia($request->file('image'))->toMediaCollection('Level');
        }

        $input = $request->validated();

        foreach(Level::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $level->id,
                'sourceable_type' => get_class($level),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Level', 'action' => 'updated']), 'success');
        return redirect()->route('admin.levels.index');
    }

    public function destroy(Level $level)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $level->delete();

        toast(__('global.crud_actions', ['module' => 'Level', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyLevelRequest $request)
    {
        Level::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
