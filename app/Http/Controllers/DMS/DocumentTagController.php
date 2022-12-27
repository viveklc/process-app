<?php

namespace App\Http\Controllers\DMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\DMS\MassDestroyDocTagRequest;
use App\Http\Requests\DMS\StoreDocTagRequest;
use App\Http\Requests\DMS\UpdateDocTagRequest;
use App\Models\DMS\DocTag;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class DocumentTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->can('read-document-tag'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inputSearchString = $request->input('s', '');
        $tags = DocTag::select('id','document_tag_name','document_tag_type')
            ->when($inputSearchString, function($query) use ($inputSearchString) {
                $query->where(function($query) use ($inputSearchString) {
                    $query->orWhere('document_tag_name', 'LIKE', '%'.$inputSearchString.'%')
                        ->orWhere('document_tag_type', 'LIKE', '%'.$inputSearchString.'%');
                });
            })
            ->isActive()
            ->orderBy('document_tag_name')
            ->paginate(config('app-config.datatable_default_row_count'))
            ->withQueryString();

        return view('dms.doctags.index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('create-tag'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tagTypes = ['' => 'Please Select'] + Arr::sort(DocTag::TAG_TYPES);
        return view('dms.doctags.create',compact('tagTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocTagRequest $request)
    {
        abort_if(!auth()->user()->can('create-tag'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tag = DocTag::create($request->validated());

        toast(__('global.crud_actions', ['module' => 'Document Tag', 'action' => 'created']), 'success');
        return redirect()->route('dms.document-tags.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tagTypes = ['' => 'Please Select'] + Arr::sort(DocTag::TAG_TYPES);
        $tag = DocTag::find($id);

        return view('dms.doctags.edit',compact('tag','tagTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDocTagRequest $request, $id)
    {
        abort_if(!auth()->user()->can('update-tag'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tag = DocTag::findOrFail($id);
        $tag->update($request->validated());

        toast(__('global.crud_actions', ['module' => 'Document Tag', 'action' => 'updated']), 'success');
        return redirect()->route('dms.document-tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocTag $tag)
    {
        abort_if(!auth()->user()->can('delete-tag'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tag->update([
            'is_active' => 3
        ]);

        toast(__('global.crud_actions', ['module' => 'Document Tag', 'action' => 'deleted']), 'success');
        return back();
    }

    public function massDestroy(MassDestroyDocTagRequest $request)
    {
        DocTag::whereIn('id', $request->ids)
            ->update([
                'is_active' => 3,
                'updatedby_userid' => auth()->id(),
            ]);

        toast(__('global.crud_actions', ['module' => 'Document Tag', 'action' => 'deleted']), 'success');
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
