<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Models\Course;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $courses = Course::select('id','name','short_description','long_description','tags')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%');
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();
        return view('courses.index', [
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->can('create-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all();
        return view('courses.create', compact('tags'));
    }

    public function store(StoreCourseRequest $request)
    {
        $tags = NULL;
        if(!empty($request->tags)) {
            $tags = implode(',', $request->tags);
        }
        $course = Course::create($request->except('course_image_url','tags') + [
            'tags'   => $tags,
        ]);

        if($request->hasFile('course_image_url') && $request->file('course_image_url')->isValid()) {
            $course->addMedia($request->file('course_image_url'))->toMediaCollection('Course');
        }

        toast(__('global.crud_actions', ['module' => 'Course', 'action' => 'created']), 'success');
        return redirect()->route('admin.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(!auth()->user()->can('show-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        abort_if(!auth()->user()->can('update-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all();

        return view('courses.edit', compact('course', 'tags'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $tags = NULL;
        if(!empty($request->tags)) {
            $tags = implode(',', $request->tags);
        }
        $course->update($request->except('course_image_url','tags') + [
            'tags'   => $tags,
        ]);

        if($request->hasFile('course_image_url') && $request->file('course_image_url')->isValid()) {
            $course->addMedia($request->file('course_image_url'))->toMediaCollection('Course');
        }

        toast(__('global.crud_actions', ['module' => 'Course', 'action' => 'updated']), 'success');
        return redirect()->route('admin.courses.index');
    }

    public function destroy(Course $course)
    {
        abort_if(!auth()->user()->can('delete-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Course', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
