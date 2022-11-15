<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\Content\Book;
use Illuminate\Http\Request;
use App\Models\Content\Detail;
use App\Models\Content\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyChapterRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ChapterController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $bookId = $request->input('book_id', '');
        $chapters = collect([]);

        $chapters = Chapter::select('id', 'name', 'short_description', 'long_description', 'sequence', 'tags', 'course_id', 'level_id', 'subject_id', 'book_id', 'status')
            ->with('course:id,name')
            ->with('level:id,name')
            ->with('subject:id,name')
            ->with('book:id,name');

        if(filled($bookId)) {
            $chapters = $chapters->where('book_id', $bookId);
        }

        $chapters =  $chapters->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('name', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('course', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        })
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('level', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        })
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('subject', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        })
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('book', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')->isActive();
                            });
                        });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        return view('chapters.index', [
            'chapters' => $chapters,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('chapters.create');
    }

    public function store(StoreChapterRequest $request)
    {
        $book = Book::find($request->book_id);
        $chapter = Chapter::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'sequence' => $request->sequence,
            'course_id' => $book->course_id ?? NULL,
            'level_id' => $book->level_id ?? NULL,
            'subject_id' => $book->subject_id ?? NULL,
            'book_id' => $book->id ?? '',
            'tags' => $request->tags,
            'status' => $request->status
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $chapter->addMedia($request->file('image'))->toMediaCollection('Chapter');
        }

        $input = $request->validated();

        foreach(Chapter::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $chapter->id,
                'sourceable_type' => get_class($chapter),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Chapter', 'action' => 'created']), 'success');
        return redirect()->route('admin.chapters.index' ,['book_id' => $request->book_id]);
    }

    public function show(Chapter $chapter)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('chapters.show', compact('chapter'));
    }

    public function edit(Chapter $chapter)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalDetails = Detail::where([
            'sourceable_id' => $chapter->id,
            'sourceable_type' => get_class($chapter),
        ])
        ->isActive()
        ->get()->pluck('detail_keyvalue');

        return view('chapters.edit', compact('chapter', 'additionalDetails'));
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter)
    {
        $book = Book::find($request->book_id);
        $chapter->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'sequence' => $request->sequence,
            'course_id' => $book->course_id ?? NULL,
            'level_id' => $book->level_id ?? NULL,
            'subject_id' => $book->subject_id ?? NULL,
            'book_id' => $book->id ,
            'tags' => $request->tags,
            'status' => $request->status
        ]);

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $chapter->addMedia($request->file('image'))->toMediaCollection('Chapter');
        }

        $input = $request->validated();

        foreach(Chapter::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $chapter->id,
                'sourceable_type' => get_class($chapter),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Chapter', 'action' => 'updated']), 'success');
        if($request->input('book_id_query'))
        {
            return redirect()->route('admin.chapters.index', ['book_id' => $request->input('book_id_query')]);
        }

        return redirect()->route('admin.chapters.index');
    }

    public function destroy(Chapter $chapter)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $chapter->delete();

        toast(__('global.crud_actions', ['module' => 'Chapter', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyChapterRequest $request)
    {
        Chapter::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
