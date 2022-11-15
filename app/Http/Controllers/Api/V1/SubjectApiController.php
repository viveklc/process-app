<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Models\Content\Subject;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubjectApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::with(['course', 'level'])->isActive()->get();

        return response()->success(trans('api.model_details', ['model' => 'Subject']), SubjectResource::collection($subjects), Response::HTTP_OK);
    }

    public function show(Subject $subject)
    {
        $subject->load(['course', 'level']);

        return response()->success(trans('api.model_details', ['model' => 'Subject']), new SubjectResource($subject), Response::HTTP_OK);
    }
}
