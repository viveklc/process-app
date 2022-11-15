<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Content\Course;
use Symfony\Component\HttpFoundation\Response;

class CourseApiController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('read-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::query()
            ->isActive()
            ->get();

        return response()->success('success', CourseResource::collection($courses), Response::HTTP_OK);
    }

    public function show(Course $course)
    {
        abort_if(!auth()->user()->can('read-course'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->success('success', new CourseResource($course), Response::HTTP_OK);
    }
}
