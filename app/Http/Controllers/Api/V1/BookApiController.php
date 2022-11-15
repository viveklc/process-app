<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Content\Book;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::with(['course', 'level', 'subject'])->isActive()->get();

        return response()->success(trans('api.model_details', ['model' => 'Book']), BookResource::collection($books), Response::HTTP_OK);
    }

    public function show(Book $book)
    {
        $book->load(['course', 'level', 'subject']);

        return response()->success(trans('api.model_details', ['model' => 'Book']), new BookResource($book), Response::HTTP_OK);
    }
}
