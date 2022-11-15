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
                        Chapters</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            @if(request()->get('book_id'))
                                <a href="{{ route('admin.chapters.index', ['book_id' => request()->get('book_id')]) }}">Chapter</a>
                            @else
                                <a href="{{ route('admin.chapters.index') }}">Chapter</a>
                            @endif
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Add</li>
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
                        <form id="" class="form" method="POST" action="{{ route("admin.chapters.store") }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ request()->get('book_id') }}" />

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Name</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="Name" name="name" value="{{ old('name', '') }}" required />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Short Description</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid  {{ $errors->has('short_description') ? 'is-invalid' : '' }}" placeholder="Short Description" name="short_description"  required cols="30" rows="5">{{ old('short_description', '') }}</textarea>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Long Description</span>
                                </label>
                                <!--end::Label-->
                                <textarea class="form-control form-control-solid  {{ $errors->has('long_description') ? 'is-invalid' : '' }}" placeholder="Long Description" name="long_description"  required cols="30" rows="5">{{ old('long_description', '') }}</textarea>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Sequence</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('sequence') ? 'is-invalid' : '' }}" placeholder="Sequence" name="sequence" value="{{ old('sequence', '') }}"  />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">Tags</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has('tags') ? 'is-invalid' : '' }}" placeholder="Tag Name" name="tags" value="{{ old('tags', '') }}" />
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Status</span>
                                </label>
                                <!--end::Label-->
                                <select
                                    class="form-select form-control form-select-solid {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                    style="width: 100%;" name="status" id="status" required>
                                    <option value="">Please Select</option>
                                    @foreach (config('lms-config.chapter.chapter_status') as $statusKey => $statusValue)
                                        <option value="{{ $statusKey }}"
                                            {{ old('status') == $statusKey ? 'selected' : '' }}>{{ $statusValue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                    <span class="required">Image</span>
                                </label>
                                <!--end::Label-->
                                <input type="file"
                                    class="form-control form-control-solid  {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                    placeholder="Image" name="image" required />
                            </div>
                            <!--end::Input group-->

                            <!--Additional Info Start-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">Additional Info</label> <br/>
                            @forelse ( \App\Models\Content\Chapter::ADDITIONAL_DETAILS as $key => $value)
                            <div class="d-flex flex-column mb-8 fv-row">
                                <!--begin::Label-->
                                <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="">{{ $value['value'] }}</span>
                                </label>
                                <!--end::Label-->
                                <input type="text" class="form-control form-control-solid  {{ $errors->has($key) ? 'is-invalid' : '' }}" placeholder="{{ $value['value'] }}" name="{{ $key }}" value="{{ old($key, '') }}" />
                            </div>
                            @empty
                                &nbsp;
                            @endforelse
                            <!--Additional Info End-->

                            <div>
                                <button type="submit" id="kt_modal_new_ticket_submit" class="btn btn-primary">
                                    <span class="indicator-label"> {{ trans('global.save') }}</span>
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
