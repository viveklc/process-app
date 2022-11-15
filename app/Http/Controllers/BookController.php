<?php

namespace App\Http\Controllers;
use App\Models\Content\Book;
use App\Models\Content\Detail;
use Illuminate\Http\Request;
use App\Http\Requests\MassDestroyBookRequest;
use App\Models\Content\Subject;
use Symfony\Component\HttpFoundation\Response;
use Alert;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BookController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $subjectId = $request->input('subject_id', '');
        $books = collect([]);

        $books = Book::select('id', 'name', 'short_description', 'long_description',  'tags', 'course_id', 'level_id', 'subject_id', 'status')
            ->with('course:id,name')
            ->with('level:id,name')
            ->with('subject:id,name');

        if(filled($subjectId)) {
            $books = $books->where('subject_id', $subjectId);
        }

        $books =  $books->when($inputSearchString, function($query) use ($inputSearchString) {
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
                        });
                });
            })
            ->isActive()
            ->orderBy('name')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        return view('books.index', [
            'books' => $books,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('books.create');
    }

    public function store(StoreBookRequest $request)
    {

        $subject = Subject::find($request->subject_id);
        $book = Book::create([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'course_id' => $subject->course_id ?? NULL,
            'level_id' => $subject->level_id ?? NULL,
            'subject_id' => $subject->id ?? NULL,
            'tags' => $request->tags,
        ]);

        if($request->hasFile('front_image') && $request->file('front_image')->isValid()) {
            $book->addMedia($request->file('front_image'))->toMediaCollection('BookFrontCover');
        }

        if($request->hasFile('back_image') && $request->file('back_image')->isValid()) {
            $book->addMedia($request->file('back_image'))->toMediaCollection('BookBackCover');
        }

        $input = $request->validated();

        foreach(Book::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $book->id,
                'sourceable_type' => get_class($book),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Book', 'action' => 'created']), 'success');
        return redirect()->route('admin.books.index' ,['subject_id' => $request->subject_id]);
    }

    public function show(Book $book)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalDetails = Detail::where([
                'sourceable_id' => $book->id,
                'sourceable_type' => get_class($book),
            ])
            ->isActive()
            ->get()->pluck('detail_keyvalue');

        return view('books.edit', compact('book', 'additionalDetails'));
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $subject = Subject::find($request->subject_id);
        $book->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'course_id' => $subject->course_id ?? NULL,
            'level_id' => $subject->level_id ?? NULL,
            'subject_id' => $subject->id ?? NULL,
            'tags' => $request->tags,
        ]);

        if($request->hasFile('front_image') && $request->file('front_image')->isValid()) {
            $book->addMedia($request->file('front_image'))->toMediaCollection('BookFrontCover');
        }

        if($request->hasFile('back_image') && $request->file('back_image')->isValid()) {
            $book->addMedia($request->file('back_image'))->toMediaCollection('BookBackCover');
        }

        $input = $request->validated();

        foreach(Book::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $book->id,
                'sourceable_type' => get_class($book),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Book', 'action' => 'updated']), 'success');
        if($request->input('subject_id_query'))
        {
            return redirect()->route('admin.books.index', ['subject_id' => $request->input('subject_id_query')]);
        }

        return redirect()->route('admin.books.index');
    }

    public function destroy(Book $book)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $book->delete();

        toast(__('global.crud_actions', ['module' => 'Book', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyBookRequest $request)
    {
        Book::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
