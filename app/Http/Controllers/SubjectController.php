<?php

namespace App\Http\Controllers;
use App\Models\Content\Tag;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Content\Level;
use App\Models\Content\Course;
use App\Models\Content\Detail;
use App\Models\Content\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroySubjectRequest;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-subject'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $subjects = Subject::with('course','level')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%');
                })
                ->WhereHas('course', function ($query)use($inputSearchString) {
                    $query->where('name', 'Like', '%' . $inputSearchString . '%');
                })
                ->orWhereHas('level', function ($query)use($inputSearchString) {
                    $query->where('name', 'Like', '%' . $inputSearchString . '%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();
        return view('subjects.index', [
            'subjects' => $subjects,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('create-subject'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $levels = Level::isActive()
            ->get();
        $courses = Course::isActive()
            ->get();
        $tags = Tag::isActive()
            ->get();
        return view('subjects.create', compact('levels','courses','tags'));
    }

    public function store(StoreSubjectRequest $request)
    {
        $tags = NULL;
        if(!empty($request->tags)) {
            $tags = implode(',', $request->tags);
        }

        $subject = Subject::create($request->safe()->only('name', 'short_description', 'long_description', 'course_id', 'level_id') + [
            'tags'   => $tags,
        ]);

        if($request->hasFile('subject_image_url') && $request->file('subject_image_url')->isValid()) {
            $subject->addMedia($request->file('subject_image_url'))->toMediaCollection('Subject');
        }

        $input = $request->validated();

        foreach(Subject::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'detail_source_id' => $subject->id,
                'detail_source_type' => get_class($subject),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Subject', 'action' => 'created']), 'success');
        return redirect()->route('admin.subjects.index');
    }

    public function show(Subject $subject)
    {
        abort_if(!auth()->user()->can('show-subject'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        abort_if(!auth()->user()->can('update-subject'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $levels = Level::isActive()
            ->get();
        $courses = Course::isActive()
            ->get();
        $tags = Tag::isActive()
            ->get();

        $additionalDetails = Detail::where([
            // 'sourceable_id' => $subject->id,
            // 'sourceable_type' => get_class($subject),
            'detail_source_id' => $subject->id,
            'detail_source_type' => get_class($subject),
        ])
        ->isActive()
        ->get()->pluck('detail_keyvalue');

        return view('subjects.edit', compact('subject', 'levels','courses','tags', 'additionalDetails'));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $tags = NULL;
        if(!empty($request->tags)) {
            $tags = implode(',', $request->tags);
        }
        $subject->update($request->safe()->only('name', 'short_description', 'long_description', 'course_id', 'level_id') + [
            'tags'   => $tags,
        ]);

        if($request->hasFile('subject_image_url') && $request->file('subject_image_url')->isValid()) {
            $subject->addMedia($request->file('subject_image_url'))->toMediaCollection('Subject');
        }

        $input = $request->validated();

        foreach(Subject::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'detail_source_id' => $subject->id,
                'detail_source_type' => get_class($subject),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Subject', 'action' => 'updated']), 'success');
        return redirect()->route('admin.subjects.index');
    }

    public function destroy(Subject $subject)
    {
        abort_if(!auth()->user()->can('delete-subject'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subject->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Subject', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroySubjectRequest $request)
    {
        Subject::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
