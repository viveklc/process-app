<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\Content\Chapter;
use Symfony\Component\HttpFoundation\Response;

class ChapterApiController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('read-chapter'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapters = Chapter::query()
            ->isActive()
            ->get();

        return response()->success('success', ChapterResource::collection($chapters), Response::HTTP_OK);
    }

    public function show(Chapter $chapter)
    {
        abort_if(!auth()->user()->can('read-chapter'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->success('success', new ChapterResource($chapter), Response::HTTP_OK);
    }
}
