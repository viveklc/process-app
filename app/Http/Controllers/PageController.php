<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\Content\Page;
use Illuminate\Http\Request;
use App\Models\Content\Detail;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Requests\MassDestroyPageRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PageController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $chapterId = $request->input('chapter_id', '');
        $pages = collect([]);

        $pages = Page::select('id', 'chapter_id', 'page_type', 'page_content', 'page_content_url', 'page_sequence', 'is_first', 'is_last', 'is_composite', 'book_id', 'is_conditional', 'tags', 'status')
            ->with('chapter:id,name')
            ->with('chapter.book:id,name');
        if(filled($chapterId)) {
            $pages = $pages->where('chapter_id', $chapterId);
        }
        $pages = $pages->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('page_type', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere('status', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('chapter.book', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')
                                ->isActive();
                            });
                        })
                        ->orWhere(function($query) use ($inputSearchString) {
                            $query->whereHas('chapter', function(Builder $builder) use ($inputSearchString) {
                                $builder->where('name', 'LIKE', '%'.$inputSearchString.'%')
                                ->isActive();
                            });
                        });
                });
            })
            ->isActive()
            ->orderBy('id')
            ->paginate(config('app-config.datatable_default_row_count', 25))
            ->withQueryString();

        return view('pages.index', [
            'pages' => $pages,
        ]);
    }

    public function create()
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->safe()->only('chapter_id', 'page_type', 'page_content', 'page_content_url', 'page_sequence', 'is_first', 'is_last', 'is_composite', 'is_conditional', 'tags', 'status'));

        $input = $request->validated();

        foreach(Page::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $page->id,
                'sourceable_type' => get_class($page),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Page', 'action' => 'created']), 'success');
        return redirect()->route('admin.pages.index', ['chapter_id' => $request->chapter_id]);
    }

    public function show(Page $page)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalDetails = Detail::where([
            'sourceable_id' => $page->id,
            'sourceable_type' => get_class($page),
        ])
        ->isActive()
        ->get()->pluck('detail_keyvalue');

        return view('pages.edit', compact('page', 'additionalDetails'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->safe()->only('chapter_id', 'page_type', 'page_content', 'page_content_url', 'page_sequence', 'is_first', 'is_last', 'is_composite', 'is_conditional', 'tags', 'status'));

        $input = $request->validated();

        foreach(Page::ADDITIONAL_DETAILS as $key => $value) {
            Detail::updateOrCreate([
                'sourceable_id' => $page->id,
                'sourceable_type' => get_class($page),
                'detail_keyname' => $key
            ], [
                'detail_keyvalue' => $input[$key] ?? null,
                'detail_keyvalueunit' => $value['unit']
            ]);
        }

        toast(__('global.crud_actions', ['module' => 'Page', 'action' => 'updated']), 'success');

        if($request->input('chapter_id_query'))
        {
            return redirect()->route('admin.pages.index', ['chapter_id' => $request->input('chapter_id_query')]);
        }

        return redirect()->route('admin.pages.index');
    }

    public function destroy(Page $page)
    {
        abort_if(!auth()->user()->hasRole('admin'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        toast(__('global.crud_actions', ['module' => 'Page', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyPageRequest $request)
    {
        Page::whereIn('id', request('ids'))
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
