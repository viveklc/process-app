<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Models\Content\Level;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LevelApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $levels = Level::with(['course'])->isActive()->get();

        return response()->success(trans('api.model_details', ['model' => 'Level']), LevelResource::collection($levels), Response::HTTP_OK);
    }

    public function show(Level $level)
    {
        $level->load(['course']);

        return response()->success(trans('api.model_details', ['model' => 'Level']), new LevelResource($level), Response::HTTP_OK);
    }

}
