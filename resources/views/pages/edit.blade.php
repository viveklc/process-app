@extends('layouts.admin')
@section('content')
<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Pages</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            @if(request()->get('chapter_id'))
                                <a href="{{ route('admin.pages.index', ['chapter_id' => request()->get('chapter_id')]) }}">Page</a>
                            @else
                                <a href="{{ route('admin.pages.index') }}">Page</a>
                            @endif
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Update</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Card-->
                <div class="card">
                    <!--begin::Card body-->
                    <div class="card-body pt-7">
                        <form class="form" method="POST" action="{{ route("admin.pages.update", ['page' => $page]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @if(request()->get('chapter_id'))
                                <input type="hidden" name="chapter_id_query" value="{{ request()->get('chapter_id') }}" />
                            @endif
                            <input type="hidden" name="chapter_id" value="{{ $page->chapter_id }}" />
                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Page Type</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-control form-select-solid {{ $errors->has('page_type') ? 'is-invalid' : '' }}"  style="width: 100%;" name="page_type" id="page_type" required >
                                    <option value="">Please Select</option>
                                    @foreach(config('lms-config.page.page_type') as $key => $value)
                                        <option value="{{ $key }}" {{ (old('page_type') ? old('page_type') : ($page->page_type ?? '')) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Page Content</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid  {{ $errors->has('page_content') ? 'is-invalid' : '' }}" placeholder="Page Content" name="page_content"  required cols="30" rows="5">{{ old('page_content', $page->page_content) }}</textarea>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Page Content URL</span>
                                </label>
                                <!--end::Label-->
                                <input type="url" class="form-control form-control-solid  {{ $errors->has('page_content_url') ? 'is-invalid' : '' }}" placeholder="Page Content URL" name="page_content_url" value="{{ old('page_content_url', $page->page_content_url) }}" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Page Sequence</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('page_sequence') ? 'is-invalid' : '' }}" placeholder="Page Sequence" name="page_sequence" value="{{ old('page_sequence', $page->page_sequence) }}" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Is First</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class="form-control-solid  {{ $errors->has('is_first') ? 'is-invalid' : '' }}"  name="is_first" value="{{ old('is_first', $page->is_first) }}" {{ (old('is_first') || $page->is_first === 'yes') ? 'checked' : '' }} />
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Is Last</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class=" form-control-solid {{ $errors->has('is_last') ? 'is-invalid' : '' }}"  name="is_last" value="{{ old('is_last', $page->is_last) }}" {{ (old('is_last') || $page->is_last === 'yes') ? 'checked' : '' }} />
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Is Composite</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class=" form-control-solid {{ $errors->has('is_composite') ? 'is-invalid' : '' }}"  name="is_composite" value="{{ old('is_composite', $page->is_composite) }}" {{ (old('is_composite') || $page->is_composite === 'yes') ? 'checked' : '' }} />
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->

                                                        <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Is Conditional</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" class=" form-control-solid {{ $errors->has('is_conditional') ? 'is-invalid' : '' }}"  name="is_conditional" value="{{ old('is_conditional', $page->is_conditional) }}" {{ (old('is_conditional') || $page->is_conditional === 'yes') ? 'checked' : '' }}  />
                                </label>
                                <!--end::Label-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Tags</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('tags') ? 'is-invalid' : '' }}" placeholder="Tag Name" name="tags" value="{{ old('tags', $page->tags) }}" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Status</span>
                                </label>
                                <!--end::Label-->
                                <select class="form-select form-control form-select-solid {{ $errors->has('status') ? 'is-invalid' : '' }}"  style="width: 100%;" name="status" id="status" required >
                                    <option value="">Please Select</option>
                                    @foreach(config('lms-config.page.page_status') as $statusKey => $statusValue)
                                        <option value="{{ $statusKey }}" {{ (old('status') ? old('status') : ($page->status ?? '')) == $statusKey ? 'selected' : '' }}>{{ $statusValue }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--Additional Info Start-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br/>
                            @forelse ( \App\Models\Content\Page::ADDITIONAL_DETAILS as $key => $value)
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">{{ $value['value'] }}</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}" placeholder="{{ $value['value'] }}" name="{{ $key }}" value="{{ old($key, ($additionalDetails[$loop->index] ?? '')) }}" />
                            </div>
                            @empty
                                &nbsp;
                            @endforelse
                            <!--Additional Info End-->

                            <div>
                                <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                    <span class="indicator-label"> {{ trans('global.update') }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end:::Main-->
@endsection
