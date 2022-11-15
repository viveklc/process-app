<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Content\Page;
use Symfony\Component\HttpFoundation\Response;

class PageApiController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('read-page'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pages = Page::query()
            ->isActive()
            ->get();

        return response()->success('success', PageResource::collection($pages), Response::HTTP_OK);
    }

    public function show(Page $page)
    {
        abort_if(!auth()->user()->can('read-page'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return response()->success('success', new PageResource($page), Response::HTTP_OK);
    }
}
